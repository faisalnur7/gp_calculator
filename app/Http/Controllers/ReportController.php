<?php

namespace App\Http\Controllers;

use App\Helpers\GoldCalculator;
use App\Models\Document;
use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function documents(Request $request)
    {
        $shops      = Shop::orderBy('name')->get();
        $categories = JewelleryCategory::orderBy('name')->get();
        $items      = JewelleryItem::orderBy('name')->get();
        $statuses   = ['pending', 'approved', 'rejected'];

        $q = Document::query()
            ->join('shops', 'shops.id', '=', 'documents.shop_id')
            ->join('jewellery_items', 'jewellery_items.id', '=', 'documents.jewellery_item_id');

        if ($request->filled('shop_id'))     $q->where('documents.shop_id', $request->shop_id);
        if ($request->filled('category_id')) $q->where('jewellery_items.jewellery_category_id', $request->category_id);
        if ($request->filled('item_id'))     $q->where('documents.jewellery_item_id', $request->item_id);
        if ($request->filled('gold_type'))   $q->where('documents.gold_type', $request->gold_type);
        if ($request->filled('status'))      $q->where('documents.status', $request->status);
        if ($request->filled('date_from'))   $q->whereDate('documents.document_date', '>=', $request->date_from);
        if ($request->filled('date_to'))     $q->whereDate('documents.document_date', '<=', $request->date_to);

        $byStatus = (clone $q)
            ->select('documents.status', DB::raw('count(*) as count'))
            ->groupBy('documents.status')
            ->pluck('count', 'status');

        $byShop = (clone $q)
            ->select(
                'shops.name as shop_name',
                DB::raw('count(documents.id) as total_docs'),
                DB::raw('sum(documents.total_points) as total_points'),
                DB::raw('sum(documents.total_grams) as total_grams'),
                DB::raw('sum(documents.subtotal) as total_value')
            )
            ->groupBy('shops.id', 'shops.name')
            ->orderByDesc('total_value')
            ->get();

        // Convert summed points back to Vori/Ana/Roti/Point for each row
        $byShop->transform(function ($row) {
            $w = GoldCalculator::fromPoint((int) $row->total_points);
            $row->w_vori  = $w['vori'];
            $row->w_ana   = $w['ana'];
            $row->w_roti  = $w['roti'];
            $row->w_point = $w['point'];
            return $row;
        });

        $grandPoints = $byShop->sum('total_points');
        $grandW      = GoldCalculator::fromPoint((int) $grandPoints);

        $grand = [
            'docs'   => $byShop->sum('total_docs'),
            'points' => $grandPoints,
            'vori'   => $grandW['vori'],
            'ana'    => $grandW['ana'],
            'roti'   => $grandW['roti'],
            'point'  => $grandW['point'],
            'grams'  => $byShop->sum('total_grams'),
            'value'  => $byShop->sum('total_value'),
        ];

        return view('reports.documents', compact('byStatus', 'byShop', 'grand', 'shops', 'categories', 'items', 'statuses'));
    }

    public function shops(Request $request)
    {
        $shopList   = Shop::orderBy('name')->get();
        $categories = JewelleryCategory::orderBy('name')->get();
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;
        $filterShop = $request->shop_id;
        $filterCat  = $request->category_id;
        $goldType   = $request->gold_type;

        $rows = Shop::query()
            ->when($filterShop, fn($q) => $q->where('id', $filterShop))
            ->withCount(['documents' => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)])
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'total_points')
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'total_grams')
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'subtotal')
            ->orderByDesc('documents_count')
            ->get();

        $rows->transform(function ($shop) {
            $w = GoldCalculator::fromPoint((int) $shop->documents_sum_total_points);
            $shop->w_vori  = $w['vori'];
            $shop->w_ana   = $w['ana'];
            $shop->w_roti  = $w['roti'];
            $shop->w_point = $w['point'];
            return $shop;
        });

        $grandPoints = (int) $rows->sum('documents_sum_total_points');
        $grandW      = GoldCalculator::fromPoint($grandPoints);

        $grand = [
            'docs'  => $rows->sum('documents_count'),
            'vori'  => $grandW['vori'],
            'ana'   => $grandW['ana'],
            'roti'  => $grandW['roti'],
            'point' => $grandW['point'],
            'grams' => $rows->sum('documents_sum_total_grams'),
            'value' => $rows->sum('documents_sum_subtotal'),
        ];

        return view('reports.shops', ['shops' => $rows, 'shopList' => $shopList, 'categories' => $categories, 'grand' => $grand]);
    }

    public function inventory(Request $request)
    {
        $categories = JewelleryCategory::orderBy('name')->get();
        $dateFrom   = $request->date_from;
        $dateTo     = $request->date_to;
        $filterCat  = $request->category_id;
        $goldType   = $request->gold_type;

        $items = JewelleryItem::with('category')
            ->when($filterCat, fn($q) => $q->where('jewellery_category_id', $filterCat))
            ->withCount(['documents' => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)])
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'total_points')
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'total_grams')
            ->withSum(['documents'   => fn($q) => $this->applyDocFilters($q, $dateFrom, $dateTo, $goldType, $filterCat)], 'subtotal')
            ->orderByDesc('documents_count')
            ->get();

        $items->transform(function ($item) {
            $w = GoldCalculator::fromPoint((int) $item->documents_sum_total_points);
            $item->w_vori  = $w['vori'];
            $item->w_ana   = $w['ana'];
            $item->w_roti  = $w['roti'];
            $item->w_point = $w['point'];
            return $item;
        });

        $grandPoints = (int) $items->sum('documents_sum_total_points');
        $grandW      = GoldCalculator::fromPoint($grandPoints);

        $grand = [
            'docs'  => $items->sum('documents_count'),
            'vori'  => $grandW['vori'],
            'ana'   => $grandW['ana'],
            'roti'  => $grandW['roti'],
            'point' => $grandW['point'],
            'grams' => $items->sum('documents_sum_total_grams'),
            'value' => $items->sum('documents_sum_subtotal'),
        ];

        return view('reports.inventory', compact('items', 'categories', 'grand'));
    }

    private function applyDocFilters($q, $dateFrom, $dateTo, $goldType, $categoryId = null): void
    {
        if ($dateFrom)   $q->whereDate('document_date', '>=', $dateFrom);
        if ($dateTo)     $q->whereDate('document_date', '<=', $dateTo);
        if ($goldType)   $q->where('gold_type', $goldType);
        if ($categoryId) $q->whereHas('jewelleryItem', fn($j) => $j->where('jewellery_category_id', $categoryId));
    }
}
