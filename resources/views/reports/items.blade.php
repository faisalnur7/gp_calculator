@extends('layouts.app')
@section('title', 'Items Report')
@section('heading', 'Items Report')
@section('subheading', 'Summary by category with weight breakdown')

@section('content')
<form method="GET" action="/reports/items" class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
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
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Status</label>
            <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)<option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>@endforeach
            </select></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50"></div>
        <div><label class="block text-xs font-medium text-slate-500 mb-1.5">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50"></div>
    </div>
    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply</button>
        <a href="/reports/items" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
    </div>
</form>
<div class="flex justify-end mb-4">
    <a href="/reports/items/pdf?{{ http_build_query(request()->all()) }}" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-black text-sm font-semibold px-4 py-2 rounded-xl transition">
        <svg class="w-5 h-5 text-red-400" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H8a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14a2 2 0 0 0 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg>
        Export PDF
    </a>
</div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    @php $colors=['pending'=>'bg-yellow-50 text-yellow-700 border-yellow-200','approved'=>'bg-emerald-50 text-emerald-700 border-emerald-200','rejected'=>'bg-red-50 text-red-700 border-red-200']; @endphp
    @foreach(['pending','approved','rejected'] as $s)
    <div class="bg-white rounded-2xl border {{ $colors[$s] }} p-5">
        <p class="text-2xl font-bold">{{ $byStatus[$s] ?? 0 }}</p>
        <p class="text-sm font-medium capitalize mt-1">{{ $s }} Items</p>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <p class="text-sm font-semibold text-slate-700">Items by Category</p>
        <p class="text-xs text-slate-400">1 Vori = 16 Ana · 1 Ana = 6 Roti · 1 Roti = 10 Point</p>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-4 py-3 text-slate-500 font-medium">Category</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Items</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Vori</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Ana</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Roti</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Point</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Total Pts</th>
                <th class="text-center px-4 py-3 text-slate-500 font-medium">Grams</th>
                <th class="text-right px-4 py-3 text-slate-500 font-medium">Total Value</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($byCategory as $row)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium text-slate-800">{{ $row->category_name }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $row->total_items }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $row->w_vori }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $row->w_ana }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $row->w_roti }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $row->w_point }}</td>
                <td class="px-4 py-3 text-center text-slate-500 text-xs">{{ number_format($row->total_points) }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ number_format($row->total_grams, 4) }}g</td>
                <td class="px-4 py-3 text-right font-semibold text-amber-600">{{ number_format($row->total_value, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-5 py-10 text-center text-slate-400">No data found.</td></tr>
            @endforelse
        </tbody>
        @if($byCategory->isNotEmpty())
        <tfoot class="border-t-2 border-slate-300 bg-amber-50">
            <tr>
                <td class="px-4 py-3 font-bold text-slate-800">Grand Total</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['items'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['vori'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['ana'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['roti'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ $grand['point'] }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-500 text-xs">{{ number_format($grand['points']) }}</td>
                <td class="px-4 py-3 text-center font-bold text-slate-800">{{ number_format($grand['grams'], 4) }}g</td>
                <td class="px-4 py-3 text-right font-bold text-amber-600 text-base">{{ number_format($grand['value'], 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection
