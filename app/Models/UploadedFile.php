<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadedFile extends Model
{
    use HasFactory;   protected $fillable = [
        'file_name',
        'filled_form_id',
        'type'
    ];
    public function filledForm(): BelongsTo
    {
        return $this->belongsTo(FilledForm::class);
    }
}
