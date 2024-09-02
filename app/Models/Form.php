<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
    ];
    
    public function filledForms(): HasMany
    {
        return $this->hasMany(FilledForm::class);
    }

    public function RequestTypes(): HasMany
    {
        return $this->hasMany(RequestType::class);
    }

  
}
