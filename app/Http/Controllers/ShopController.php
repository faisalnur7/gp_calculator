<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::query()
            ->when($request->search, fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->code,   fn($q) => $q->where('code',  'like', '%'.$request->code.'%'))
            ->latest()
            ->get();

        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:shops,code',
            'profile' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        Shop::create($data);

        return redirect('/shops')->with('success', 'Shop created successfully.');
    }

    public function edit(string $id)
    {
        return view('shops.edit', ['shop' => Shop::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $shop = Shop::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:shops,code,'.$id,
            'profile' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $shop->update($data);

        return redirect('/shops')->with('success', 'Shop updated successfully.');
    }

    public function destroy(string $id)
    {
        Shop::findOrFail($id)->delete();

        return redirect('/shops')->with('success', 'Shop deleted.');
    }

    public function show(string $id) { return redirect('/shops'); }
}
