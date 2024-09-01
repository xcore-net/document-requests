<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StageType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'role'
    ];
    public function requestTypes(): BelongsToMany
    {
        return $this->belongsToMany(RequestType::class,'request_stages');
    }
    
   

  
}