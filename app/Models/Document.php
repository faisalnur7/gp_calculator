<?php

namespace App\Models;

use App\Helpers\GoldCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'shop_id',
        'jewellery_item_id',
        'gold_type',
        'document_date',
        'reference_number',
        'vori',
        'ana',
        'roti',
        'point',
        'total_vori',
        'total_ana',
        'total_roti',
        'total_points',
        'total_grams',
        'unit_price_per_gram',
        'subtotal',
        'notes',
        'status',
    ];

    protected $casts = [
        'document_date'       => 'date',
        'vori'                => 'integer',
        'ana'                 => 'integer',
        'roti'                => 'integer',
        'point'               => 'integer',
        'total_vori'          => 'integer',
        'total_ana'           => 'integer',
        'total_roti'          => 'integer',
        'total_points'        => 'integer',
        'total_grams'         => 'decimal:4',
        'unit_price_per_gram' => 'decimal:4',
        'subtotal'            => 'decimal:4',
    ];

    /** Auto-compute total_points, total_grams, subtotal before saving */
    protected static function booted(): void
    {
        static::saving(function (Document $doc) {
            $v = (int) $doc->vori;
            $a = (int) $doc->ana;
            $r = (int) $doc->roti;
            $p = (int) $doc->point;

            $totalPoints = GoldCalculator::toPoint($v, $a, $r, $p);
            $breakdown   = GoldCalculator::fromPoint($totalPoints);

            $doc->total_points = $totalPoints;
            $doc->total_vori   = $breakdown['vori'];
            $doc->total_ana    = $breakdown['ana'];
            $doc->total_roti   = $breakdown['roti'];
            // point stays as remainder — already in $breakdown['point']
            $doc->total_grams  = GoldCalculator::toGrams($v, $a, $r, $p);

            if ($doc->unit_price_per_gram) {
                $doc->subtotal = round((float) $doc->total_grams * (float) $doc->unit_price_per_gram, 4);
            }
        });
    }

    /** Formatted weight string e.g. "2v 5a 3r 7p" */
    public function getWeightFormattedAttribute(): string
    {
        return GoldCalculator::format(
            (int) $this->vori,
            (int) $this->ana,
            (int) $this->roti,
            (int) $this->point
        );
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function jewelleryItem(): BelongsTo
    {
        return $this->belongsTo(JewelleryItem::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(DocumentPhoto::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(DocumentAttachment::class);
    }
}
