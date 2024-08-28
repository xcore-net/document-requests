<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    public function clients(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
}
