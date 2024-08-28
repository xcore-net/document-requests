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
        return $this->HasMany(Request::class);
    }

    public function payments():HasMany
    {
        return $this->HasMany(Payment::class);
    }
    public function filledforms(): HasMany
    {
        return $this->HasMany(FilledForm::class);
    }  
    public function uploadedFiles(): HasManyThrough
    {
        return $this->hasManyThrough(UploadedFile::class, FilledForm::class);
    }
}
