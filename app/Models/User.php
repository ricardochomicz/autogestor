<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function hasPermission($permission)
    {
        $permissions = $this->permissions()->pluck('name')->toArray();

        return in_array($permission, $permissions);
    }

    // Relacionamento: um usuário pertence a um administrador
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id'); // admin_id é a chave estrangeira
    }

    // Relacionamento: um administrador tem vários usuários associados a ele
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function permissionsAvailable(array $filters = [])
    {
        return Permission::whereNotIn('id', function ($query) {
            $query->select('user_permissions.permission_id');
            $query->from('user_permissions');
            $query->whereRaw("user_permissions.user_id={$this->id}");
        })
            ->filter($filters)
            ->paginate();
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhereHas('permissions', function ($query) use ($search) {
                    $query->where('label', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function transferBrandsTo(User $newOwner)
    {
        return Brand::where('user_id', $this->id)->update(['user_id' => $newOwner->id]);
    }
}
