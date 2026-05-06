<?php

namespace App\Http\Controllers;

use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use Illuminate\Http\Request;

class JewelleryItemController extends Controller
{
    public function index()
    {
        return view('items.index', [
            'items' => JewelleryItem::with('category')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('items.create', ['categories' => JewelleryCategory::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jewellery_category_id' => 'nullable|exists:jewellery_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        JewelleryItem::create($data);

        return redirect('/jewellery-items')->with('success', 'Item created successfully.');
    }

    public function edit(string $id)
    {
        return view('items.edit', [
            'item' => JewelleryItem::findOrFail($id),
            'categories' => JewelleryCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $item = JewelleryItem::findOrFail($id);

        $data = $request->validate([
            'jewellery_category_id' => 'nullable|exists:jewellery_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item->update($data);

        return redirect('/jewellery-items')->with('success', 'Item updated successfully.');
    }

    public function destroy(string $id)
    {
        JewelleryItem::findOrFail($id)->delete();

        return redirect('/jewellery-items')->with('success', 'Item deleted.');
    }

    public function show(string $id) { return redirect('/jewellery-items'); }
}
