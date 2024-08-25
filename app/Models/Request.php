<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    public function stages(): BelongsToMany
    {
        return $this->belongsToMany(Stage::class,'request_stages');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class,'client_requests');
    }
}
