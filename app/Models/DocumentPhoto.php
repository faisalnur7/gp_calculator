<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Document;

class DocumentPhoto extends Model
{
    protected $fillable = [
        'document_id',
        'path',
        'caption',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
