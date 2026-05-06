<?php

namespace App\Models;

use App\Helpers\GoldCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JewelleryItem extends Model
{
    protected $fillable = [
        'item_name',
        'category_id',
        'shop_id',
        'reference',
        'gold_type',
        'purchase_date',
        'weight',
        'subtotal',
        'price',
        'vori', 'ana', 'roti', 'points',
        'total_vori', 'total_ana', 'total_roti', 'total_points', 'total_grams',
        'unit_price_per_gram',
        'document_photo',
        'item_photo',
    ];

    protected $casts = [
        'purchase_date'       => 'date',
        'weight'              => 'integer',
        'vori'                => 'integer',
        'ana'                 => 'integer',
        'roti'                => 'integer',
        'points'              => 'integer',
        'total_vori'          => 'integer',
        'total_ana'           => 'integer',
        'total_roti'          => 'integer',
        'total_points'        => 'integer',
        'total_grams'         => 'decimal:4',
        'unit_price_per_gram' => 'decimal:4',
        'subtotal'            => 'decimal:4',
        'price'               => 'decimal:4',
    ];

    protected static function booted(): void
    {
        static::saving(function (JewelleryItem $item) {
            $v = (int) $item->vori;
            $a = (int) $item->ana;
            $r = (int) $item->roti;
            $p = (int) $item->points;

            $totalPoints = GoldCalculator::toPoint($v, $a, $r, $p);
            $breakdown   = GoldCalculator::fromPoint($totalPoints);

            $item->total_points = $totalPoints;
            $item->total_vori   = $breakdown['vori'];
            $item->total_ana    = $breakdown['ana'];
            $item->total_roti   = $breakdown['roti'];
            $item->total_grams  = GoldCalculator::toGrams($v, $a, $r, $p);
            $item->weight       = $totalPoints;

            if ($item->unit_price_per_gram) {
                $item->subtotal = round((float) $item->total_grams * (float) $item->unit_price_per_gram, 4);
                $item->price    = $item->subtotal;
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JewelleryCategory::class, 'category_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
