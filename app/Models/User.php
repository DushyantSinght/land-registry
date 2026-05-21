<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'role', 'is_active', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRegistrar(): bool
    {
        return in_array($this->role, ['admin', 'registrar']);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'     => 'Administrator',
            'registrar' => 'Registrar',
            'viewer'    => 'Viewer',
            default     => ucfirst($this->role),
        };
    }
}
