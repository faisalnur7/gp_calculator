<?php

namespace App\Http\Controllers;

use App\Helpers\GoldCalculator;
use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function items(Request $request)
    {
        $data = $this->getItemsData($request);
        $data['categories'] = JewelleryCategory::orderBy('name')->get();
        $data['shops']      = Shop::orderBy('name')->get();
        return view('reports.items', $data);
    }

    public function itemsPdf(Request $request)
    {
        $data = $this->getItemsData($request);
        $data['dateLabel'] = $this->dateLabel($request);
        return Pdf::loadView('reports.pdf.items', $data)
            ->setPaper('a4', 'landscape')
            ->download('items-report' . ($data['dateLabel'] ? '-' . str_replace(' ', '_', $data['dateLabel']) : '') . '.pdf');
    }

    public function shops(Request $request)
    {
        $data = $this->getShopsData($request);
        $data['shopList']   = Shop::orderBy('name')->get();
        $data['categories'] = JewelleryCategory::orderBy('name')->get();
        return view('reports.shops', $data);
    }

    public function shopsPdf(Request $request)
    {
        $data = $this->getShopsData($request);
        $data['dateLabel'] = $this->dateLabel($request);
        return Pdf::loadView('reports.pdf.shops', $data)
            ->setPaper('a4', 'landscape')
            ->download('shops-report' . ($data['dateLabel'] ? '-' . str_replace(' ', '_', $data['dateLabel']) : '') . '.pdf');
    }

    public function inventory(Request $request)
    {
        $data = $this->getInventoryData($request);
        $data['categories'] = JewelleryCategory::orderBy('name')->get();
        $data['shops']      = Shop::orderBy('name')->get();
        return view('reports.inventory', $data);
    }

    public function inventoryPdf(Request $request)
    {
        $data = $this->getInventoryData($request);
        $data['dateLabel'] = $this->dateLabel($request);
        return Pdf::loadView('reports.pdf.inventory', $data)
            ->setPaper('a4', 'landscape')
            ->download('inventory-report' . ($data['dateLabel'] ? '-' . str_replace(' ', '_', $data['dateLabel']) : '') . '.pdf');
    }

    // ── Shared data builders ──────────────────────────────────────────────────

    private function getItemsData(Request $request): array
    {
        $q = JewelleryItem::query()
            ->leftJoin('jewellery_categories', 'jewellery_categories.id', '=', 'jewellery_items.category_id')
            ->leftJoin('shops', 'shops.id', '=', 'jewellery_items.shop_id');

        if ($request->filled('category_id')) $q->where('jewellery_items.category_id', $request->category_id);
        if ($request->filled('shop_id'))     $q->where('jewellery_items.shop_id', $request->shop_id);
        if ($request->filled('gold_type'))   $q->where('jewellery_items.gold_type', $request->gold_type);
        if ($request->filled('date_from'))   $q->whereDate('jewellery_items.purchase_date', '>=', $request->date_from);
        if ($request->filled('date_to'))     $q->whereDate('jewellery_items.purchase_date', '<=', $request->date_to);

        $byCategory = (clone $q)
            ->select(
                'jewellery_categories.name as category_name',
                DB::raw('count(jewellery_items.id) as total_items'),
                DB::raw('sum(jewellery_items.total_points) as total_points'),
                DB::raw('sum(jewellery_items.total_grams) as total_grams'),
                DB::raw('sum(jewellery_items.subtotal) as total_value')
            )
            ->groupBy('jewellery_categories.id', 'jewellery_categories.name')
            ->orderByDesc('total_value')
            ->get()
            ->map(function ($row) {
                $w = GoldCalculator::fromPoint((int) $row->total_points);
                $row->w_vori  = $w['vori'];
                $row->w_ana   = $w['ana'];
                $row->w_roti  = $w['roti'];
                $row->w_point = $w['point'];
                return $row;
            });

        $grandPoints = (int) $byCategory->sum('total_points');
        $grandW      = GoldCalculator::fromPoint($grandPoints);
        $grand = [
            'items'  => $byCategory->sum('total_items'),
            'points' => $grandPoints,
            'vori'   => $grandW['vori'],
            'ana'    => $grandW['ana'],
            'roti'   => $grandW['roti'],
            'point'  => $grandW['point'],
            'grams'  => $byCategory->sum('total_grams'),
            'value'  => $byCategory->sum('total_value'),
        ];

        return compact('byCategory', 'grand');
    }

    private function getShopsData(Request $request): array
    {
        $rows = Shop::query()
            ->when($request->shop_id, fn($q) => $q->where('id', $request->shop_id))
            ->withCount(['jewelleryItems' => fn($q) => $this->applyFilters($q, $request)])
            ->withSum(['jewelleryItems'   => fn($q) => $this->applyFilters($q, $request)], 'total_points')
            ->withSum(['jewelleryItems'   => fn($q) => $this->applyFilters($q, $request)], 'total_grams')
            ->withSum(['jewelleryItems'   => fn($q) => $this->applyFilters($q, $request)], 'subtotal')
            ->withMin(['jewelleryItems'   => fn($q) => $this->applyFilters($q, $request)], 'purchase_date')
            ->get()
            ->map(function ($shop) {
                $w = GoldCalculator::fromPoint((int) $shop->jewellery_items_sum_total_points);
                $shop->w_vori  = $w['vori'];
                $shop->w_ana   = $w['ana'];
                $shop->w_roti  = $w['roti'];
                $shop->w_point = $w['point'];
                return $shop;
            });

        $sortDir  = in_array($request->sort_weight, ['asc', 'desc']) ? $request->sort_weight : null;
        $sortDate = in_array($request->sort_date,   ['asc', 'desc']) ? $request->sort_date   : null;

        if ($sortDir) {
            $rows = $rows->sortBy('jewellery_items_sum_total_points', SORT_REGULAR, $sortDir === 'desc');
        } elseif ($sortDate) {
            $rows = $rows->sortBy('jewellery_items_min_purchase_date', SORT_REGULAR, $sortDate === 'desc');
        } else {
            $rows = $rows->sortByDesc('jewellery_items_count');
        }
        $rows = $rows->values();

        $grandPoints = (int) $rows->sum('jewellery_items_sum_total_points');
        $grandW      = GoldCalculator::fromPoint($grandPoints);
        $grand = [
            'items' => $rows->sum('jewellery_items_count'),
            'vori'  => $grandW['vori'],
            'ana'   => $grandW['ana'],
            'roti'  => $grandW['roti'],
            'point' => $grandW['point'],
            'grams' => $rows->sum('jewellery_items_sum_total_grams'),
            'value' => $rows->sum('jewellery_items_sum_subtotal'),
        ];

        return compact('rows', 'grand');
    }

    private function getInventoryData(Request $request): array
    {
        $sortDir  = in_array($request->sort_weight, ['asc', 'desc']) ? $request->sort_weight : null;
        $sortDate = in_array($request->sort_date,   ['asc', 'desc']) ? $request->sort_date   : null;

        $items = JewelleryItem::with(['category', 'shop'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->shop_id,     fn($q) => $q->where('shop_id', $request->shop_id))
            ->when($request->gold_type,   fn($q) => $q->where('gold_type', $request->gold_type))
            ->when($request->date_from,   fn($q) => $q->whereDate('purchase_date', '>=', $request->date_from))
            ->when($request->date_to,     fn($q) => $q->whereDate('purchase_date', '<=', $request->date_to))
            ->when($sortDir,               fn($q) => $q->orderBy('total_points', $sortDir))
            ->when(!$sortDir && $sortDate, fn($q) => $q->orderBy('purchase_date', $sortDate))
            ->when(!$sortDir && !$sortDate, fn($q) => $q->latest())
            ->get();

        $grandPoints = (int) $items->sum('total_points');
        $grandW      = GoldCalculator::fromPoint($grandPoints);
        $grand = [
            'items' => $items->count(),
            'vori'  => $grandW['vori'],
            'ana'   => $grandW['ana'],
            'roti'  => $grandW['roti'],
            'point' => $grandW['point'],
            'grams' => $items->sum('total_grams'),
            'value' => $items->sum('subtotal'),
        ];

        return compact('items', 'grand');
    }

    private function applyFilters($q, Request $request): void
    {
        if ($request->filled('category_id')) $q->where('category_id', $request->category_id);
        if ($request->filled('gold_type'))   $q->where('gold_type', $request->gold_type);
        if ($request->filled('date_from'))   $q->whereDate('purchase_date', '>=', $request->date_from);
        if ($request->filled('date_to'))     $q->whereDate('purchase_date', '<=', $request->date_to);
    }

    private function dateLabel(Request $request): string
    {
        $from = $request->filled('date_from') ? $request->date_from : null;
        $to   = $request->filled('date_to')   ? $request->date_to   : null;
        if ($from && $to) return $from . ' to ' . $to;
        if ($from)        return 'from ' . $from;
        if ($to)          return 'to ' . $to;
        return '';
    }
}
