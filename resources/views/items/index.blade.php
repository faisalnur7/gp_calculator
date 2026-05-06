@extends('layouts.app')
@section('title', 'Jewellery Items')
@section('heading', 'Jewellery Items')
@section('subheading', 'All jewellery items with purchase details')

@section('content')

<div class="flex justify-end mb-5">
    <a href="/jewellery-items/create" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Item
    </a>
</div>

<form method="GET" action="/jewellery-items" class="bg-white rounded-2xl border border-slate-200 p-5 mb-5">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Category</label>
            <select name="category_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Shop</label>
            <select name="shop_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">All Shops</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}" @selected(request('shop_id') == $shop->id)>{{ $shop->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Gold Type</label>
            <select name="gold_type" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">All Types</option>
                @foreach(['22K','21K','18K'] as $g)
                    <option value="{{ $g }}" @selected(request('gold_type') == $g)>{{ $g }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Sort by Weight</label>
            <select name="sort_weight" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">Default</option>
                <option value="asc"  @selected(request('sort_weight')=='asc')>Weight ↑ Low to High</option>
                <option value="desc" @selected(request('sort_weight')=='desc')>Weight ↓ High to Low</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Sort by Date</label>
            <select name="sort_date" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">Default</option>
                <option value="desc" @selected(request('sort_date')=='desc')>Date ↓ New to Old</option>
                <option value="asc"  @selected(request('sort_date')=='asc')>Date ↑ Old to New</option>
            </select>
        </div>
    </div>
    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Filter</button>
        <a href="/jewellery-items" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
    </div>
</form>

<div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Item Name</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Category</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Shop</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Ref</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Gold</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Date</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Vori</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Ana</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Roti</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Points</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Grams</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Price/g</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Subtotal</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($items as $item)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-slate-400">{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                <td class="px-4 py-3 font-medium text-slate-800">
                    <div class="flex items-center gap-2">
                        @if($item->item_photo)
                            <img src="/{{ $item->item_photo }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200">
                        @endif
                        {{ $item->item_name }}
                    </div>
                </td>
                <td class="px-4 py-3">
                    @if($item->category)
                        <span class="inline-block bg-amber-100 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $item->category->name }}</span>
                    @else <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-slate-600">{{ $item->shop->name ?? '—' }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $item->reference ?? '—' }}</td>
                <td class="px-4 py-3">
                    @php $gc=['22K'=>'bg-amber-100 text-amber-700','21K'=>'bg-yellow-100 text-yellow-700','18K'=>'bg-orange-100 text-orange-700']; @endphp
                    <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full {{ $gc[$item->gold_type] ?? 'bg-slate-100 text-slate-600' }}">{{ $item->gold_type }}</span>
                </td>
                <td class="px-4 py-3 text-slate-500">{{ $item->purchase_date?->format('d M Y') ?? '—' }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->vori }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->ana }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->roti }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->points }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ number_format($item->total_grams, 4) }}g</td>
                <td class="px-4 py-3 text-right text-slate-600">{{ $item->unit_price_per_gram ? number_format($item->unit_price_per_gram, 2) : '—' }}</td>
                <td class="px-4 py-3 text-right font-semibold text-amber-600">{{ $item->subtotal ? number_format($item->subtotal, 2) : '—' }}</td>
                <td class="px-4 py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                        <a href="/jewellery-items/{{ $item->id }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 transition">View</a>
                        <a href="/jewellery-items/{{ $item->id }}/edit" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form method="POST" action="/jewellery-items/{{ $item->id }}" onsubmit="return confirm('Delete this item?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-500 hover:text-red-700 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="15" class="px-5 py-10 text-center text-slate-400">No items found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $items->links() }}</div>
@endsection
