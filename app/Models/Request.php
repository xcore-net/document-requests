<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_type_id',
        'client_id',
        'status',
        'current_stage',
    ];
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
    public function filledForm(): HasOne
    {
        return $this->hasOne(FilledForm::class);
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
