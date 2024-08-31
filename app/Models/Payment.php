<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'request_id'
    ];
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

}