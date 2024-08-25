<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    public function stages():HasMany{
        return $this->hasMany(Request::class)->withPivot('order');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Request::class)->withPivot('status');
    }
}
