<?php

namespace App\Http\Controllers;

use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class JewelleryItemController extends Controller
{
    public function index(Request $request)
    {
        $q = JewelleryItem::with(['category', 'shop'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->shop_id,     fn($q) => $q->where('shop_id', $request->shop_id))
            ->when($request->gold_type,   fn($q) => $q->where('gold_type', $request->gold_type))
            ->when($request->date_from,   fn($q) => $q->whereDate('purchase_date', '>=', $request->date_from))
            ->when($request->date_to,     fn($q) => $q->whereDate('purchase_date', '<=', $request->date_to));

        $sortDir = in_array($request->sort_weight, ['asc', 'desc']) ? $request->sort_weight : null;
        $sortDate = in_array($request->sort_date, ['asc', 'desc']) ? $request->sort_date : null;

        if ($sortDir) {
            $q = $q->orderBy('total_points', $sortDir);
        } elseif ($sortDate) {
            $q = $q->orderBy('purchase_date', $sortDate);
        } else {
            $q = $q->latest();
        }

        return view('items.index', [
            'items'      => $q->paginate(50)->withQueryString(),
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'shops'      => Shop::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('items.create', [
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'shops'      => Shop::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name'           => 'required|string|max:255',
            'category_id'         => 'nullable|exists:jewellery_categories,id',
            'shop_id'             => 'nullable|exists:shops,id',
            'reference'           => 'nullable|string|max:255',
            'gold_type'           => 'required|string|in:22K,21K,18K',
            'purchase_date'       => 'nullable|date',
            'vori'                => 'required|integer|min:0',
            'ana'                 => 'required|integer|min:0|max:15',
            'roti'                => 'required|integer|min:0|max:5',
            'points'              => 'required|integer|min:0|max:9',
            'unit_price_per_gram' => 'nullable|numeric|min:0',
            'document_photo'      => 'nullable|file|image|max:5120',
            'item_photo'          => 'nullable|file|image|max:5120',
        ]);

        $data = $this->handlePhotos($request, $data);
        JewelleryItem::create($data);

        return redirect('/jewellery-items')->with('success', 'Item created successfully.');
    }

    public function show(string $id)
    {
        return view('items.show', [
            'item' => JewelleryItem::with(['category', 'shop'])->findOrFail($id),
        ]);
    }

    public function edit(string $id)
    {
        return view('items.edit', [
            'item'       => JewelleryItem::findOrFail($id),
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'shops'      => Shop::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = JewelleryItem::findOrFail($id);

        $data = $request->validate([
            'item_name'           => 'required|string|max:255',
            'category_id'         => 'nullable|exists:jewellery_categories,id',
            'shop_id'             => 'nullable|exists:shops,id',
            'reference'           => 'nullable|string|max:255',
            'gold_type'           => 'required|string|in:22K,21K,18K',
            'purchase_date'       => 'nullable|date',
            'vori'                => 'required|integer|min:0',
            'ana'                 => 'required|integer|min:0|max:15',
            'roti'                => 'required|integer|min:0|max:5',
            'points'              => 'required|integer|min:0|max:9',
            'unit_price_per_gram' => 'nullable|numeric|min:0',
            'document_photo'      => 'nullable|file|image|max:5120',
            'item_photo'          => 'nullable|file|image|max:5120',
        ]);

        if ($request->hasFile('document_photo') && $item->document_photo) $this->deleteFile($item->document_photo);
        if ($request->hasFile('item_photo') && $item->item_photo)         $this->deleteFile($item->item_photo);

        $data = $this->handlePhotos($request, $data, $item);
        $item->update($data);

        return redirect('/jewellery-items')->with('success', 'Item updated successfully.');
    }

    public function destroy(string $id)
    {
        $item = JewelleryItem::findOrFail($id);
        if ($item->document_photo) $this->deleteFile($item->document_photo);
        if ($item->item_photo)     $this->deleteFile($item->item_photo);
        $item->delete();

        return redirect('/jewellery-items')->with('success', 'Item deleted.');
    }

    private function handlePhotos(Request $request, array $data, ?JewelleryItem $existing = null): array
    {
        foreach (['document_photo', 'item_photo'] as $field) {
            if ($request->hasFile($field)) {
                $file     = $request->file($field);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $data[$field] = 'uploads/' . $filename;
            } elseif ($existing) {
                unset($data[$field]);
            }
        }
        return $data;
    }

    private function deleteFile(string $path): void
    {
        $full = public_path($path);
        if (File::exists($full)) File::delete($full);
    }
}
