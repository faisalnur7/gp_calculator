<?php

namespace App\Http\Controllers;

use App\Models\JewelleryCategory;
use Illuminate\Http\Request;

class JewelleryCategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => JewelleryCategory::withCount('jewelleryItems')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        JewelleryCategory::create($data);

        return redirect('/jewellery-categories')->with('success', 'Category created successfully.');
    }

    public function edit(string $id)
    {
        return view('categories.edit', ['category' => JewelleryCategory::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $category = JewelleryCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect('/jewellery-categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        JewelleryCategory::findOrFail($id)->delete();

        return redirect('/jewellery-categories')->with('success', 'Category deleted.');
    }

    public function show(string $id) { return redirect('/jewellery-categories'); }
}
