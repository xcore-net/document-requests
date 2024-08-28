<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;



class RequestType extends Model
{
    use HasFactory;
    public function stageType():BelongsToMany{
        return $this->belongsToMany(StageType::class,'request_stages');
    }
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
