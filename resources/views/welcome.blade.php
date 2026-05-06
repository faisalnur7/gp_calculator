@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Welcome back, '.auth()->user()->name)

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Document::count() }}</p>
            <p class="text-sm text-slate-500">Total Documents</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Shop::count() }}</p>
            <p class="text-sm text-slate-500">Total Shops</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\JewelleryItem::count() }}</p>
            <p class="text-sm text-slate-500">Jewellery Items</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\JewelleryCategory::count() }}</p>
            <p class="text-sm text-slate-500">Categories</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @foreach([
        ['href'=>'/documents','title'=>'Documents','desc'=>'Manage jewellery documents, photos and attachments.'],
        ['href'=>'/shops','title'=>'Shops','desc'=>'View and manage all registered shops.'],
        ['href'=>'/jewellery-items','title'=>'Jewellery Items','desc'=>'Browse and manage jewellery item catalogue.'],
        ['href'=>'/jewellery-categories','title'=>'Categories','desc'=>'Organise jewellery into categories.'],
        ['href'=>'/reports/documents','title'=>'Document Report','desc'=>'View detailed document analytics and summaries.'],
        ['href'=>'/reports/inventory','title'=>'Inventory Report','desc'=>'Track stock levels and jewellery inventory.'],
    ] as $card)
    <a href="{{ $card['href'] }}" class="bg-white rounded-2xl p-5 border border-slate-200 hover:border-amber-300 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-semibold text-slate-700">{{ $card['title'] }}</span>
            <svg class="w-4 h-4 text-slate-300 group-hover:text-amber-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </div>
        <p class="text-xs text-slate-400">{{ $card['desc'] }}</p>
    </a>
    @endforeach
</div>
@endsection
