@extends('layouts.app')
@section('title', 'Document #'.$document->id)
@section('heading', 'Document Details')

@section('content')
<div class="max-w-2xl space-y-5">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Reference</p>
                <p class="text-lg font-bold text-slate-800">{{ $document->reference_number ?? '—' }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $gc = ['22K'=>'bg-amber-100 text-amber-700','21K'=>'bg-yellow-100 text-yellow-700','18K'=>'bg-orange-100 text-orange-700'];
                    $sc = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700'];
                @endphp
                <span class="text-sm font-bold px-3 py-1.5 rounded-full {{ $gc[$document->gold_type] ?? 'bg-slate-100 text-slate-600' }}">{{ $document->gold_type }}</span>
                <span class="text-sm font-semibold px-3 py-1.5 rounded-full {{ $sc[$document->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($document->status) }}</span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm pt-2 border-t border-slate-100">
            <div><p class="text-slate-400 text-xs mb-0.5">Shop</p><p class="font-medium text-slate-700">{{ $document->shop->name }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Category</p><p class="font-medium text-slate-700">{{ $document->jewelleryItem->category->name ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Item</p><p class="font-medium text-slate-700">{{ $document->jewelleryItem->name }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Date</p><p class="font-medium text-slate-700">{{ $document->document_date?->format('d M Y') ?? '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Gold Type</p><p class="font-medium text-slate-700">{{ $document->gold_type }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Weight (Vori / Ana / Roti / Point)</p><p class="font-medium text-slate-700">{{ $document->vori }} / {{ $document->ana }} / {{ $document->roti }} / {{ $document->point }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Total Grams</p><p class="font-medium text-slate-700">{{ $document->total_grams ? number_format($document->total_grams, 4).'g' : '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Unit Price / Gram</p><p class="font-medium text-slate-700">{{ $document->unit_price_per_gram ? number_format($document->unit_price_per_gram, 2) : '—' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Subtotal</p><p class="text-lg font-bold text-amber-600">{{ $document->subtotal ? number_format($document->subtotal, 2) : '—' }}</p></div>
        </div>
        @if($document->notes)
        <div class="pt-2 border-t border-slate-100">
            <p class="text-slate-400 text-xs mb-1">Notes</p>
            <p class="text-sm text-slate-600">{{ $document->notes }}</p>
        </div>
        @endif

        @if($document->attachments->isNotEmpty())
        <div class="pt-2 border-t border-slate-100">
            <p class="text-slate-400 text-xs mb-2">Attachments</p>
            <div class="space-y-2">
                @foreach($document->attachments as $att)
                <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5">
                    <div class="flex items-center gap-3 min-w-0">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <a href="/{{ $att->path }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate">{{ basename($att->path) }}</a>
                        <span class="text-xs text-slate-400">{{ $att->type }}</span>
                    </div>
                    <form method="POST" action="/attachments/{{ $att->id }}" onsubmit="return confirm('Delete this attachment?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-medium text-red-500 hover:text-red-700 transition ml-4 shrink-0">Delete</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="flex gap-3 pt-2 border-t border-slate-100">
            <a href="/documents/{{ $document->id }}/edit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Edit</a>
            <a href="/documents" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2.5 rounded-xl border border-slate-200 transition">Back</a>
        </div>
    </div>
</div>
@endsection
