<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestType extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'form_id',
        'bill_id'
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
    public function stageTypes(): BelongsToMany
    {
        return $this->belongsToMany(StageType::class, 'request_stages');
    }
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
