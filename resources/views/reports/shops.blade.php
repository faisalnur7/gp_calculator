@extends('layouts.app')
@section('title', 'Shop Report')
@section('heading', 'Shop Report')
@section('subheading', 'Overview of all shops with weight and value breakdown')

@section('content')

{{-- Filters --}}
<form method="GET" action="/reports/shops" class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
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
                @foreach($shopList as $shop)
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
    </div>
    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply Filters</button>
        <a href="/reports/shops" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
    </div>
</form>

<div class="flex items-center gap-4 mb-3 text-xs text-slate-400">
    <span>Weight: <strong class="text-slate-600">1 Vori = 16 Ana · 1 Ana = 6 Roti · 1 Roti = 10 Point</strong> — totals converted via Point system</span>
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Shop</th>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Code</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Docs</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Vori</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Ana</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Roti</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Point</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Grams</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Total Value</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($shops as $shop)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium text-slate-800">{{ $shop->name }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $shop->code ?? '—' }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $shop->documents_count }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $shop->w_vori }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $shop->w_ana }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $shop->w_roti }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $shop->w_point }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ number_format($shop->documents_sum_total_grams ?? 0, 4) }}g</td>
                <td class="px-4 py-3 text-right font-semibold text-amber-600">{{ number_format($shop->documents_sum_subtotal ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-5 py-10 text-center text-slate-400">No data found for the selected filters.</td></tr>
            @endforelse
        </tbody>
        @if($shops->isNotEmpty())
        <tfoot class="border-t-2 border-slate-300 bg-amber-50">
            <tr>
                <td class="px-4 py-3 font-bold text-slate-800" colspan="2">Grand Total</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['docs'] }}</td>
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
