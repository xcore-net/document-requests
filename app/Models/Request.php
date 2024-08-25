<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Request extends Model
{
    use HasFactory;
    public function stages():BelongsToMany{
        return $this->belongsToMany(Request::class,'request_stages');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Request::class,'client_requests');
    }
}
