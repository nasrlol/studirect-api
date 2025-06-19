<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory, HasApiTokens;
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
