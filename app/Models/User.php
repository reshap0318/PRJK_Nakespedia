<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'avatar_path',
        'last_login',
        'password',
        'role'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
    ];

    const ROLE_TEXT = [
        1 => 'Super Admin',
        2 => 'Admin',
        3 => 'User'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return $this->avatar_path ? (Storage::exists($this->avatar_path) ? Storage::url($this->avatar_path) : asset('custom/images/avatar.png')) : asset('custom/images/avatar.png');
            }
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return $value;
            },
            set: function($value)
            {
                return bcrypt($value);
            }
        );
    }

    protected function roleText(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                if(isset(self::ROLE_TEXT[$this->role])) return self::ROLE_TEXT[$this->role];
                return "Not Set";
            }
        );
    }

    public function isSuAdmin(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return in_array($this->role, [1]);
            }
        );
    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return in_array($this->role, [1, 2]);
            }
        );
    }

    public function isUser(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return in_array($this->role, [1, 2, 3]);
            }
        );
    }
}
