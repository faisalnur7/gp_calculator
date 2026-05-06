@extends('layouts.app')
@section('title', 'Item #'.$item->id)
@section('heading', 'Jewellery Item Details')

@section('content')
<div class="max-w-2xl space-y-5">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">

        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Item Name</p>
                <p class="text-xl font-bold text-slate-800 mt-0.5">{{ $item->item_name }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $gc = ['22K'=>'bg-amber-100 text-amber-700','21K'=>'bg-yellow-100 text-yellow-700','18K'=>'bg-orange-100 text-orange-700'];
                @endphp
                <span class="text-sm font-bold px-3 py-1.5 rounded-full {{ $gc[$item->gold_type] ?? 'bg-slate-100 text-slate-600' }}">{{ $item->gold_type }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm pt-2 border-t border-slate-100">
            <div><p class="text-slate-400 text-xs mb-0.5">Category</p>
                <p class="font-medium text-slate-700">{{ $item->category->name ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Shop</p>
                <p class="font-medium text-slate-700">{{ $item->shop->name ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Reference</p>
                <p class="font-medium text-slate-700">{{ $item->reference ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Purchase Date</p>
                <p class="font-medium text-slate-700">{{ $item->purchase_date?->format('d M Y') ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Weight (Vori / Ana / Roti / Points)</p>
                <p class="font-medium text-slate-700">{{ $item->vori }} / {{ $item->ana }} / {{ $item->roti }} / {{ $item->points }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Total Vori / Ana / Roti</p>
                <p class="font-medium text-slate-700">{{ $item->total_vori }} / {{ $item->total_ana }} / {{ $item->total_roti }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Total Points</p>
                <p class="font-medium text-slate-700">{{ number_format($item->total_points) }} pts</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Total Grams</p>
                <p class="font-medium text-slate-700">{{ number_format($item->total_grams, 4) }}g</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Unit Price / Gram</p>
                <p class="font-medium text-slate-700">{{ $item->unit_price_per_gram ? number_format($item->unit_price_per_gram, 2) : '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Subtotal / Price</p>
                <p class="text-xl font-bold text-amber-600">{{ $item->subtotal ? number_format($item->subtotal, 2) : '—' }}</p></div>
        </div>

        @if($item->document_photo || $item->item_photo)
        <div class="pt-2 border-t border-slate-100">
            <p class="text-slate-400 text-xs mb-3">Photos</p>
            <div class="grid grid-cols-2 gap-4">
                @if($item->document_photo)
                <div>
                    <p class="text-xs text-slate-500 mb-1.5">Document Photo</p>
                    <a href="/{{ $item->document_photo }}" target="_blank">
                        <img src="/{{ $item->document_photo }}" class="w-full h-40 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition">
                    </a>
                </div>
                @endif
                @if($item->item_photo)
                <div>
                    <p class="text-xs text-slate-500 mb-1.5">Item Photo</p>
                    <a href="/{{ $item->item_photo }}" target="_blank">
                        <img src="/{{ $item->item_photo }}" class="w-full h-40 object-cover rounded-xl border border-slate-200 hover:opacity-90 transition">
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="flex gap-3 pt-2 border-t border-slate-100">
            <a href="/jewellery-items/{{ $item->id }}/edit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Edit</a>
            <a href="/jewellery-items" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2.5 rounded-xl border border-slate-200 transition">Back</a>
        </div>
    </div>
</div>
@endsection
