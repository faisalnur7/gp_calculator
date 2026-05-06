@extends('layouts.app')
@section('title', 'Documents')
@section('heading', 'Documents')
@section('subheading', 'Manage all jewellery documents')

@section('content')

<div class="flex justify-end mb-5">
    <a href="/documents/create" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Document
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="/documents" class="bg-white rounded-2xl border border-slate-200 p-5 mb-5">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
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
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Item</label>
            <select name="item_id" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">All Items</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" @selected(request('item_id') == $item->id)>{{ $item->name }}</option>
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
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Status</label>
            <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                <option value="">All Statuses</option>
                @foreach(['pending','approved','rejected'] as $s)
                    <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
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
    <div class="flex items-center justify-between mt-4">
        <div class="flex gap-3">
            <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Filter</button>
            <a href="/documents" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
        </div>
    </div>
</form>

<div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Ref No.</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Shop</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Category</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Item</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Gold</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Date</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Weight</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Subtotal</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Status</th>
                <th class="text-right px-5 py-3 text-slate-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($documents as $doc)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 text-slate-400">{{ ($documents->currentPage() - 1) * $documents->perPage() + $loop->iteration }}</td>
                <td class="px-5 py-3 font-medium text-slate-800">{{ $doc->reference_number ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-600">{{ $doc->shop->name }}</td>
                <td class="px-5 py-3">
                    @if($doc->jewelleryItem->category)
                        <span class="inline-block bg-amber-100 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $doc->jewelleryItem->category->name }}</span>
                    @else
                        <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-5 py-3 text-slate-600">{{ $doc->jewelleryItem->name }}</td>
                <td class="px-5 py-3">
                    @php $gc=['22K'=>'bg-amber-100 text-amber-700','21K'=>'bg-yellow-100 text-yellow-700','18K'=>'bg-orange-100 text-orange-700']; @endphp
                    <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full {{ $gc[$doc->gold_type] ?? 'bg-slate-100 text-slate-600' }}">{{ $doc->gold_type }}</span>
                </td>
                <td class="px-5 py-3 text-slate-500">{{ $doc->document_date?->format('d M Y') ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $doc->total_grams ? number_format($doc->total_grams, 2).'g' : '—' }}</td>
                <td class="px-5 py-3 text-slate-700 font-medium">{{ $doc->subtotal ? number_format($doc->subtotal, 2) : '—' }}</td>
                <td class="px-5 py-3">
                    @php $colors = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700']; @endphp
                    <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full {{ $colors[$doc->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($doc->status) }}</span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                        <a href="/documents/{{ $doc->id }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 transition">View
                            @if($doc->attachments->isNotEmpty())
                                <span class="inline-flex items-center justify-center w-4 h-4 bg-amber-500 text-white text-xs rounded-full ml-0.5">{{ $doc->attachments->count() }}</span>
                            @endif
                        </a>
                        <a href="/documents/{{ $doc->id }}/edit" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form method="POST" action="/documents/{{ $doc->id }}" onsubmit="return confirm('Delete this document?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-500 hover:text-red-700 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="11" class="px-5 py-10 text-center text-slate-400">No documents found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $documents->links() }}</div>
@endsection
