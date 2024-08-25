<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Contracts\Role;

class Stage extends Model
{
    use HasFactory;

    public function requests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class,'request_stages');
    }

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class,'stage_roles');
    }

    public function assignments() : HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
