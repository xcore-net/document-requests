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
        return $this->belongsToMany(Request::class)->withPivot('status');
    }

    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class);
    }
    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class);
    }  
    public function files(): HasManyThrough
    {
        return $this->hasManyThrough(UploadedFile::class, FilledForm::class);
    }
}
