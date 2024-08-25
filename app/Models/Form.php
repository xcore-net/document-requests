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
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

  
}
