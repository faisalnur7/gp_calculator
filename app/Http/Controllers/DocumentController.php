<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentAttachment;
use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $q = Document::with(['shop', 'jewelleryItem.category', 'attachments'])
            ->when($request->category_id, fn($q) => $q->whereHas('jewelleryItem', fn($j) => $j->where('jewellery_category_id', $request->category_id)))
            ->when($request->shop_id,     fn($q) => $q->where('shop_id', $request->shop_id))
            ->when($request->item_id,     fn($q) => $q->where('jewellery_item_id', $request->item_id))
            ->when($request->gold_type,   fn($q) => $q->where('gold_type', $request->gold_type))
            ->when($request->status,      fn($q) => $q->where('status', $request->status))
            ->when($request->date_from,   fn($q) => $q->whereDate('document_date', '>=', $request->date_from))
            ->when($request->date_to,     fn($q) => $q->whereDate('document_date', '<=', $request->date_to))
            ->latest();

        return view('documents.index', [
            'documents'  => $q->paginate(50)->withQueryString(),
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'shops'      => Shop::orderBy('name')->get(),
            'items'      => JewelleryItem::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('documents.create', [
            'shops'      => Shop::orderBy('name')->get(),
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'items'      => JewelleryItem::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id'             => 'required|exists:shops,id',
            'jewellery_item_id'   => 'required|exists:jewellery_items,id',
            'gold_type'           => 'required|string|in:22K,21K,18K',
            'document_date'       => 'nullable|date',
            'reference_number'    => 'nullable|string|max:255',
            'vori'                => 'required|integer|min:0',
            'ana'                 => 'required|integer|min:0|max:15',
            'roti'                => 'required|integer|min:0|max:5',
            'point'               => 'required|integer|min:0|max:9',
            'unit_price_per_gram' => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string',
            'status'              => 'nullable|string|in:pending,approved,rejected',
            'attachments'         => 'nullable|array',
            'attachments.*'       => 'file|max:10240',
        ]);

        $document = Document::create($data);

        $this->saveAttachments($request, $document);

        return redirect('/documents')->with('success', 'Document created successfully.');
    }

    public function show(string $id)
    {
        return view('documents.show', [
            'document' => Document::with(['shop', 'jewelleryItem.category', 'attachments'])->findOrFail($id),
        ]);
    }

    public function edit(string $id)
    {
        return view('documents.edit', [
            'document'   => Document::with('attachments')->findOrFail($id),
            'shops'      => Shop::orderBy('name')->get(),
            'categories' => JewelleryCategory::orderBy('name')->get(),
            'items'      => JewelleryItem::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $data = $request->validate([
            'shop_id'             => 'required|exists:shops,id',
            'jewellery_item_id'   => 'required|exists:jewellery_items,id',
            'gold_type'           => 'required|string|in:22K,21K,18K',
            'document_date'       => 'nullable|date',
            'reference_number'    => 'nullable|string|max:255',
            'vori'                => 'required|integer|min:0',
            'ana'                 => 'required|integer|min:0|max:15',
            'roti'                => 'required|integer|min:0|max:5',
            'point'               => 'required|integer|min:0|max:9',
            'unit_price_per_gram' => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string',
            'status'              => 'nullable|string|in:pending,approved,rejected',
            'attachments'         => 'nullable|array',
            'attachments.*'       => 'file|max:10240',
        ]);

        $document->update($data);

        $this->saveAttachments($request, $document);

        return redirect('/documents')->with('success', 'Document updated successfully.');
    }

    public function destroy(string $id)
    {
        $document = Document::with('attachments')->findOrFail($id);

        foreach ($document->attachments as $att) {
            $this->deleteFile($att->path);
        }

        $document->delete();

        return redirect('/documents')->with('success', 'Document deleted.');
    }

    public function destroyAttachment(string $id)
    {
        $att = DocumentAttachment::findOrFail($id);
        $documentId = $att->document_id;

        $this->deleteFile($att->path);
        $att->delete();

        return back()->with('success', 'Attachment deleted.');
    }

    private function saveAttachments(Request $request, Document $document): void
    {
        if (!$request->hasFile('attachments')) return;

        foreach ($request->file('attachments') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            $document->attachments()->create([
                'path' => 'uploads/' . $filename,
                'type' => $file->getClientMimeType(),
            ]);
        }
    }

    private function deleteFile(string $path): void
    {
        $full = public_path($path);
        if (File::exists($full)) {
            File::delete($full);
        }
    }
}
