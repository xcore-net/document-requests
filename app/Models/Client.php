<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model
{
    use HasFactory;

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Bill::class, 'payments');
    }
    public function filledForms(): HasMany
    {
        return $this->hasMany(FilledForm::class);
    }
    public function uploadedFiles(): HasManyThrough
    {
        return $this->hasManyThrough(UploadedFile::class, FilledForm::class);
    }
}
