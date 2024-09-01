<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'stage_id',
        'assigned_by',
        'type',
        'status',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplete::class);
    }

 
}
