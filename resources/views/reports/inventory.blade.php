@extends('layouts.app')
@section('title', 'Inventory Report')
@section('heading', 'Inventory Report')
@section('subheading', 'Full item listing with weight and value')

@section('content')
<form method="GET" action="/reports/inventory" class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Category</label>
            <select name="category_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">All Categories</option>
                @foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>@endforeach
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Shop</label>
            <select name="shop_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">All Shops</option>
                @foreach($shops as $shop)<option value="{{ $shop->id }}" @selected(request('shop_id')==$shop->id)>{{ $shop->name }}</option>@endforeach
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Gold Type</label>
            <select name="gold_type" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">All Types</option>
                @foreach(['22K','21K','18K'] as $g)<option value="{{ $g }}" @selected(request('gold_type')==$g)>{{ $g }}</option>@endforeach
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Sort by Weight</label>
            <select name="sort_weight" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">Default</option>
                <option value="asc"  @selected(request('sort_weight')=='asc')>Weight ↑ Low to High</option>
                <option value="desc" @selected(request('sort_weight')=='desc')>Weight ↓ High to Low</option>
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Sort by Date</label>
            <select name="sort_date" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">Default</option>
                <option value="desc" @selected(request('sort_date')=='desc')>Date ↓ New to Old</option>
                <option value="asc"  @selected(request('sort_date')=='asc')>Date ↑ Old to New</option>
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50"></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50"></div>
    </div>
    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply</button>
        <a href="/reports/inventory" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
    </div>
</form>

<div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Item</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Category</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Shop</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Gold</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Date</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Vori</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Ana</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Roti</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Points</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Grams</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($items as $i => $item)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 text-slate-400">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium text-slate-800">{{ $item->item_name }}</td>
                <td class="px-4 py-3">
                    @if($item->category)<span class="inline-block bg-amber-100 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $item->category->name }}</span>
                    @else <span class="text-slate-400">—</span>@endif
                </td>
                <td class="px-4 py-3 text-slate-600">{{ $item->shop->name ?? '—' }}</td>
                <td class="px-4 py-3">
                    @php $gc=['22K'=>'bg-amber-100 text-amber-700','21K'=>'bg-yellow-100 text-yellow-700','18K'=>'bg-orange-100 text-orange-700']; @endphp
                    <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full {{ $gc[$item->gold_type] ?? 'bg-slate-100 text-slate-600' }}">{{ $item->gold_type }}</span>
                </td>
                <td class="px-4 py-3 text-slate-500">{{ $item->purchase_date?->format('d M Y') ?? '—' }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->vori }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->ana }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->roti }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $item->getAttribute('points') }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ number_format($item->total_grams, 4) }}g</td>
                <td class="px-4 py-3 text-right font-semibold text-amber-600">{{ $item->subtotal ? number_format($item->subtotal, 2) : '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="12" class="px-5 py-10 text-center text-slate-400">No items found.</td></tr>
            @endforelse
        </tbody>
        @if($items->isNotEmpty())
        <tfoot class="border-t-2 border-slate-300 bg-amber-50">
            <tr>
                <td class="px-4 py-3 font-bold text-slate-800" colspan="6">Grand Total</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['vori'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['ana'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['roti'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['point'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ number_format($grand['grams'], 4) }}g</td>
                <td class="px-4 py-3 text-right font-bold text-amber-600 text-base">{{ number_format($grand['value'], 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection
