<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JewelleryCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function jewelleryItems(): HasMany
    {
        return $this->hasMany(JewelleryItem::class);
    }
}
