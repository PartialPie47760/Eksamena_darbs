<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // Tasks made by this user
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    // This users tasks
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_user_id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public const ROLE_USER = 'user';
    public const ROLE_SUPREME_USER = 'supreme_user';
    public const ROLE_ADMIN = 'admin';

    // helpers (methods)
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isSupremeUser(): bool
    {
        return $this->role === self::ROLE_SUPREME_USER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
