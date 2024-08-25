<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilledForm extends Model
{
    use HasFactory;

    public function files():HasMany{
        return $this->hasMany(UploadedFile::class);
    }

    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class);
    }
}
