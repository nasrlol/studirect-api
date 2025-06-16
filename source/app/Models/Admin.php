<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        // hashen enkel wanneer het nog niet gehashed is
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }
    public function logging(): HasMany
    {
        return $this->HasMany(Log::class);
    }
}
