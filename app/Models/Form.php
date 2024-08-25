<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Form extends Model
{
    use HasFactory;

    public function filledForms(): HasMany
    {
        return $this->hasMany(FilledForm::class);
    }

    public function files(): HasManyThrough
    {
        return $this->hasManyThrough(UploadedFile::class, FilledForm::class);
    }
}
