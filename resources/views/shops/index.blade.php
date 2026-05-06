@extends('layouts.app')
@section('title', 'Shops')
@section('heading', 'Shops')
@section('subheading', 'Manage all registered shops')

@section('content')

<div class="flex justify-end mb-5">
    <a href="/shops/create" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Shop
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="/shops" class="bg-white rounded-2xl border border-slate-200 p-5 mb-5">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Search Name</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Shop name..." class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1.5">Code</label>
            <input type="text" name="code" value="{{ request('code') }}" placeholder="Shop code..." class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
        </div>
    </div>
    <div class="flex gap-3 mt-4">
        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Filter</button>
        <a href="/shops" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2 rounded-xl border border-slate-200 transition">Reset</a>
    </div>
</form>

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Name</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Code</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Phone</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Email</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Address</th>
                <th class="text-right px-5 py-3 text-slate-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($shops as $shop)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 text-slate-400">{{ $loop->iteration }}</td>
                <td class="px-5 py-3 font-medium text-slate-800">{{ $shop->name }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $shop->code ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $shop->phone ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $shop->email ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-500">{{ Str::limit($shop->address, 40) ?? '—' }}</td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                        <a href="/shops/{{ $shop->id }}/edit" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form method="POST" action="/shops/{{ $shop->id }}" onsubmit="return confirm('Delete this shop?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-500 hover:text-red-700 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No shops found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
