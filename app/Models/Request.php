<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Request extends Model
{
    use HasFactory;
    public function stages():HasMany{
        return $this->hasMany(Stage::class);
    }
    public function requestType():BelongsTo{
        return $this->belongsTo(RequestType::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
