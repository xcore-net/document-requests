<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model
{
    use HasFactory;
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class,'client_requests');
    }

    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class,'payments');
    }
    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class,'filled_forms');
    }  
    public function uploadedFiles(): HasManyThrough
    {
        return $this->hasManyThrough(UploadedFile::class, FilledForm::class);
    }
}
