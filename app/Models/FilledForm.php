<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FilledForm extends Model
{
    use HasFactory;

    public function uploadedFiles(): HasMany
    {
        return $this->hasMany(UploadedFile::class);
    }
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
}
