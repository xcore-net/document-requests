<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stage extends Model
{
    use HasFactory;

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class)->withPivot('order');
    }

    public function bill(): HasOne
    {
        return $this->hasOne(Bill::class);
    }

    public function form(): HasOne
    {
        return $this->hasOne(Form::class);
    }
}
