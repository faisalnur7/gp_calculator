@extends('layouts.app')
@section('title', 'Add Jewellery Item')
@section('heading', 'Add Jewellery Item')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="/jewellery-items" class="space-y-5" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Item Name <span class="text-red-500">*</span></label>
                    <input type="text" name="item_name" value="{{ old('item_name') }}" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
                    <select name="category_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Shop</label>
                    <select name="shop_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                        <option value="">— None —</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" @selected(old('shop_id') == $shop->id)>{{ $shop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Reference</label>
                    <input type="text" name="reference" value="{{ old('reference') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Purchase Date</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Gold Type <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    @foreach(['22K' => 'amber', '21K' => 'yellow', '18K' => 'orange'] as $type => $color)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="gold_type" value="{{ $type }}" class="sr-only peer" @checked(old('gold_type', '22K') == $type)>
                        <div class="peer-checked:bg-{{ $color }}-500 peer-checked:text-white peer-checked:border-{{ $color }}-500 border-2 border-slate-200 rounded-xl px-4 py-3 text-center text-sm font-bold text-slate-500 hover:bg-slate-50 transition">{{ $type }}</div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">
                    Weight <span class="normal-case font-normal text-slate-400 ml-2">1 Vori = 16 Ana · 1 Ana = 6 Roti · 1 Roti = 10 Points</span>
                </p>
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Vori</label>
                        <input type="number" id="vori" name="vori" value="{{ old('vori', 0) }}" min="0" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Ana <span class="text-xs text-slate-400">(0–15)</span></label>
                        <input type="number" id="ana" name="ana" value="{{ old('ana', 0) }}" min="0" max="15" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Roti <span class="text-xs text-slate-400">(0–5)</span></label>
                        <input type="number" id="roti" name="roti" value="{{ old('roti', 0) }}" min="0" max="5" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Points <span class="text-xs text-slate-400">(0–9)</span></label>
                        <input type="number" id="points" name="points" value="{{ old('points', 0) }}" min="0" max="9" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-3">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Total Vori</span>
                        <span id="total_vori_display" class="text-sm font-bold text-slate-700">0</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Total Points</span>
                        <span id="total_points_display" class="text-sm font-bold text-slate-700">0 pts</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Total Grams</span>
                        <span id="total_grams_display" class="text-sm font-bold text-slate-700">0.0000 g</span>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Pricing</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Unit Price / Gram</label>
                        <input type="number" step="0.01" id="unit_price_per_gram" name="unit_price_per_gram" value="{{ old('unit_price_per_gram') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Subtotal / Price <span class="text-xs text-slate-400">(auto)</span></label>
                        <input type="number" step="0.0001" id="subtotal" name="subtotal" value="{{ old('subtotal') }}" readonly class="w-full border border-amber-200 bg-amber-50 rounded-xl px-4 py-2.5 text-sm font-semibold text-amber-700 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Photos <span class="normal-case font-normal text-slate-400 ml-1">(images only, max 5MB)</span></p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Document Photo</label>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-slate-300 rounded-xl px-4 py-6 cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition">
                            <svg class="w-6 h-6 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="doc-photo-name" class="text-xs text-slate-400">No file chosen</span>
                            <input type="file" name="document_photo" accept="image/*" class="hidden" onchange="previewPhoto(this,'doc-photo-preview','doc-photo-name')">
                        </label>
                        <img id="doc-photo-preview" src="" class="hidden mt-2 w-full h-32 object-cover rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Item Photo</label>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-slate-300 rounded-xl px-4 py-6 cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition">
                            <svg class="w-6 h-6 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="item-photo-name" class="text-xs text-slate-400">No file chosen</span>
                            <input type="file" name="item_photo" accept="image/*" class="hidden" onchange="previewPhoto(this,'item-photo-preview','item-photo-name')">
                        </label>
                        <img id="item-photo-preview" src="" class="hidden mt-2 w-full h-32 object-cover rounded-xl border border-slate-200">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Save</button>
                <a href="/jewellery-items" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2.5 rounded-xl border border-slate-200 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function recalc() {
    const v = parseInt(document.getElementById('vori').value)   || 0;
    const a = parseInt(document.getElementById('ana').value)    || 0;
    const r = parseInt(document.getElementById('roti').value)   || 0;
    const p = parseInt(document.getElementById('points').value) || 0;
    const pts   = v*960 + a*60 + r*10 + p;
    const grams = v*11.664 + a*0.729 + r*0.1215 + p*0.01215;
    const totalVori = Math.floor(pts / 960);
    document.getElementById('total_vori_display').textContent   = totalVori;
    document.getElementById('total_points_display').textContent = pts.toLocaleString() + ' pts';
    document.getElementById('total_grams_display').textContent  = grams.toFixed(4) + ' g';
    const price = parseFloat(document.getElementById('unit_price_per_gram').value) || 0;
    document.getElementById('subtotal').value = (grams * price).toFixed(4);
}
document.querySelectorAll('.calc-trigger').forEach(el => el.addEventListener('input', recalc));
recalc();

function previewPhoto(input, previewId, nameId) {
    const file = input.files[0];
    document.getElementById(nameId).textContent = file ? file.name : 'No file chosen';
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(previewId);
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
