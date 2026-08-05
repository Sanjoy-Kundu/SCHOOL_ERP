<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'password',
        'role_id',
        'status',
        'profile_image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: A User belongs to a dynamic Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific permission dynamically (Fixed Bug).
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->role) {
            return false;
        }

        // Checks permission relationship using the belongsTo role structure on 'slug' column
        return $this->role->permissions()->where('slug', $permission)->exists();
    }
}
