<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $hidden = ['password'];
    protected $fillable = [
        'email',
        'password',
        'profile_photo'  // Add profile photo field
    ];

    public function logging(): HasMany
    {
        return $this->HasMany(Log::class);
    }
}
