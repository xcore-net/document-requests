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
    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class,'request_stages');
    }

    public function bill(): belongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function form(): belongsTo
    {
        return $this->belongsTo(Form::class);
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'stage_roles');
    }
    public function assigments(): HasMany
    {
        return $this->HasMany(Assignment::class,);
    }

}
