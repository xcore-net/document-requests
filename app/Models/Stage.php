<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'stage_type_id',
        'request_id',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
    public function stageType(): BelongsTo
    {
        return $this->belongsTo(StageType::class);
    }
    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }

}
