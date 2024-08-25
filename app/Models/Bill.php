<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
    public function stage(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}
