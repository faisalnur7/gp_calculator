@extends('layouts.app')
@section('title', 'Edit Document')
@section('heading', 'Edit Document')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="/documents/{{ $document->id }}" class="space-y-5" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Shop <span class="text-red-500">*</span></label>
                    <select name="shop_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" @selected(old('shop_id', $document->shop_id) == $shop->id)>{{ $shop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
                    <select id="category_filter" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                        <option value="">— All Categories —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($document->jewelleryItem->jewellery_category_id == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jewellery Item <span class="text-red-500">*</span></label>
                    <select id="jewellery_item_id" name="jewellery_item_id" required class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-category="{{ $item->jewellery_category_id }}" @selected(old('jewellery_item_id', $document->jewellery_item_id) == $item->id)>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Reference Number</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number', $document->reference_number) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Document Date</label>
                    <input type="date" name="document_date" value="{{ old('document_date', $document->document_date?->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                </div>
            </div>

            {{-- Gold Type --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Gold Type <span class="text-red-500">*</span></label>
                <div class="flex gap-3">
                    @foreach(['22K' => 'amber', '21K' => 'yellow', '18K' => 'orange'] as $type => $color)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="gold_type" value="{{ $type }}" class="sr-only peer" @checked(old('gold_type', $document->gold_type) == $type)>
                        <div class="peer-checked:bg-{{ $color }}-500 peer-checked:text-white peer-checked:border-{{ $color }}-500 border-2 border-slate-200 rounded-xl px-4 py-3 text-center text-sm font-bold text-slate-500 hover:bg-slate-50 transition">
                            {{ $type }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Weight --}}
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">
                    Weight
                    <span class="normal-case font-normal text-slate-400 ml-2">1 Vori = 16 Ana · 1 Ana = 6 Roti · 1 Roti = 10 Point</span>
                </p>
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Vori</label>
                        <input type="number" id="vori" name="vori" value="{{ old('vori', $document->vori) }}" min="0" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Ana <span class="text-xs text-slate-400">(0–15)</span></label>
                        <input type="number" id="ana" name="ana" value="{{ old('ana', $document->ana) }}" min="0" max="15" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Roti <span class="text-xs text-slate-400">(0–5)</span></label>
                        <input type="number" id="roti" name="roti" value="{{ old('roti', $document->roti) }}" min="0" max="5" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Point <span class="text-xs text-slate-400">(0–9)</span></label>
                        <input type="number" id="point" name="point" value="{{ old('point', $document->point) }}" min="0" max="9" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                </div>
                <div class="mt-3 flex gap-3">
                    <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Total Points</span>
                        <span id="total_points_display" class="text-sm font-bold text-slate-700">0 pts</span>
                    </div>
                    <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Total Grams</span>
                        <span id="total_grams_display" class="text-sm font-bold text-slate-700">0.0000 g</span>
                    </div>
                    <input type="hidden" id="total_grams" name="total_grams" value="{{ $document->total_grams }}">
                </div>
            </div>

            {{-- Pricing --}}
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Pricing</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Unit Price / Gram</label>
                        <input type="number" step="0.01" id="unit_price_per_gram" name="unit_price_per_gram" value="{{ old('unit_price_per_gram', $document->unit_price_per_gram) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 calc-trigger">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Subtotal <span class="text-xs text-slate-400">(auto)</span></label>
                        <input type="number" step="0.0001" id="subtotal" name="subtotal" value="{{ old('subtotal', $document->subtotal) }}" readonly class="w-full border border-amber-200 bg-amber-50 rounded-xl px-4 py-2.5 text-sm font-semibold text-amber-700 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                        <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">
                            @foreach(['pending','approved','rejected'] as $s)
                                <option value="{{ $s }}" @selected(old('status', $document->status) == $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="1" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400">{{ old('notes', $document->notes) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Existing Attachments --}}
            @if($document->attachments->isNotEmpty())
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Existing Attachments</p>
                <div class="space-y-2">
                    @foreach($document->attachments as $att)
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5">
                        <div class="flex items-center gap-3 min-w-0">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <a href="/{{ $att->path }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate">{{ basename($att->path) }}</a>
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

            {{-- Upload New Attachments --}}
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Add More Attachments <span class="normal-case font-normal text-slate-400 ml-1">(PDF, images, etc. — max 10MB each)</span></p>
                <label class="flex flex-col items-center justify-center w-full border-2 border-dashed border-slate-300 rounded-xl px-4 py-8 cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition">
                    <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span class="text-sm text-slate-500">Click to upload or drag & drop</span>
                    <span id="file-names" class="text-xs text-slate-400 mt-1">No files selected</span>
                    <input type="file" name="attachments[]" multiple class="hidden" onchange="updateFileNames(this)">
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Update</button>
                <a href="/documents" class="text-sm font-medium text-slate-500 hover:text-slate-700 px-5 py-2.5 rounded-xl border border-slate-200 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Category → Item filter
const allOptions = [...document.querySelectorAll('#jewellery_item_id option')];
document.getElementById('category_filter').addEventListener('change', function () {
    const catId = this.value;
    const sel = document.getElementById('jewellery_item_id');
    const current = sel.value;
    sel.innerHTML = '';
    allOptions.filter(o => !o.value || !catId || o.dataset.category === catId)
              .forEach(o => sel.appendChild(o.cloneNode(true)));
    sel.value = current;
});

function toPoint(v,a,r,p) { return v*960 + a*60 + r*10 + p; }
function recalc() {
    const v = parseInt(document.getElementById('vori').value)  || 0;
    const a = parseInt(document.getElementById('ana').value)   || 0;
    const r = parseInt(document.getElementById('roti').value)  || 0;
    const p = parseInt(document.getElementById('point').value) || 0;

    const totalPts = toPoint(v, a, r, p);
    const grams    = v*11.664 + a*0.729 + r*0.1215 + p*0.01215;

    document.getElementById('total_points_display').textContent = totalPts.toLocaleString() + ' pts';
    document.getElementById('total_grams_display').textContent  = grams.toFixed(4) + ' g';
    document.getElementById('total_grams').value = grams.toFixed(4);

    const price = parseFloat(document.getElementById('unit_price_per_gram').value) || 0;
    document.getElementById('subtotal').value = (grams * price).toFixed(4);
}
document.querySelectorAll('.calc-trigger').forEach(el => el.addEventListener('input', recalc));
recalc();

function updateFileNames(input) {
    const names = [...input.files].map(f => f.name).join(', ');
    document.getElementById('file-names').textContent = names || 'No files selected';
}
</script>
@endpush
