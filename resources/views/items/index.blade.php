@extends('layouts.app')
@section('title', 'Jewellery Items')
@section('heading', 'Jewellery Items')
@section('subheading', 'Manage all jewellery items')

@section('content')
<div class="flex justify-end mb-5">
    <a href="/jewellery-items/create" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Item
    </a>
</div>
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">#</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Name</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Category</th>
                <th class="text-left px-5 py-3 text-slate-500 font-medium">Description</th>
                <th class="text-right px-5 py-3 text-slate-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($items as $item)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 text-slate-400">{{ $loop->iteration }}</td>
                <td class="px-5 py-3 font-medium text-slate-800">{{ $item->name }}</td>
                <td class="px-5 py-3">
                    @if($item->category)
                        <span class="inline-block bg-amber-100 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $item->category->name }}</span>
                    @else
                        <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-5 py-3 text-slate-500">{{ Str::limit($item->description, 50) ?? '—' }}</td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-2">
                        <a href="/jewellery-items/{{ $item->id }}/edit" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form method="POST" action="/jewellery-items/{{ $item->id }}" onsubmit="return confirm('Delete this item?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-500 hover:text-red-700 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No items found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
