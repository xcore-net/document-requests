<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadedFile extends Model
{
    use HasFactory;
    public function filledForm(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
}
