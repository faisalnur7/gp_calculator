<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Document;

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

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
