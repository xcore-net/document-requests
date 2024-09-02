<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'name',
        'price'
    ];
    
    public function RequestTypes(): HasMany
    {
        return $this->hasMany(RequestType::class);
    }

    public function payment(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
