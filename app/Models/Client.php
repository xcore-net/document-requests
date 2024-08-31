<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model
{
    use HasFactory;

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class,Request::class);
    }
    public function filledForms(): HasManyThrough
    {
        return $this->hasManyThrough(FilledForm::class,Request::class);
    }
    // public function uploadedFiles(): HasManyThrough
    // {
    //     return $this->hasMan(UploadedFile::class, FilledForm::class);
    // }
}
