<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class StageType extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'role',
        'isForClient',
        'type',
    ];

    public function requestTypes(): BelongsToMany
    {
        return $this->belongsToMany(RequestType::class, 'request_stages');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'stage_roles');
    }
}
