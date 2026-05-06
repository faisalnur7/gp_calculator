<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'code',
        'profile',
        'address',
        'phone',
        'email',
    ];

    public function jewelleryItems(): HasMany
    {
        return $this->hasMany(JewelleryItem::class);
    }
}
