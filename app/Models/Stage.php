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
    public function requests(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    public function payments(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function filledform(): BelongsTo
    {
        return $this->belongsTo(FilledForm::class);
    }
    public function stagetype(): BelongsTo
    {
        return $this->belongsTo(StageType::class);
    }
    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class,);
    }

}
