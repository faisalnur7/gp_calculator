@extends('layouts.app')
@section('title', 'Categories')
@section('heading', 'Jewellery Categories')
@section('subheading', 'Manage all jewellery categories')

@section('content')
<div class="flex justify-end mb-5">
    <a href="/jewellery-categories/create" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Category
    </a>
</div>
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Name</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Description</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Items</th>
                <th class="text-right px-5 py-3 text-slate-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $cat)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 text-slate-400">{{ $loop->iteration }}</td>
                <td class="px-5 py-3 font-medium text-slate-800">{{ $cat->name }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $cat->description ?? '—' }}</td>
                <td class="px-5 py-3 text-slate-500">{{ $cat->jewellery_items_count }}</td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                        <a href="/jewellery-categories/{{ $cat->id }}/edit" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form method="POST" action="/jewellery-categories/{{ $cat->id }}" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-500 hover:text-red-700 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
