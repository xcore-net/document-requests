<?php

namespace App\Models;

use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = [
        'stage_type_id',
        'request_id',
        'order',
        'name',
        'role',
        'type',
        'name',
        'status',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
    public function stageType(): BelongsTo
    {
        return $this->belongsTo(StageType::class);
    }
    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }
}
