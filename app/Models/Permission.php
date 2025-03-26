<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;
    //

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('label', 'LIKE', '%' . $search . '%');
        });
    }
}
