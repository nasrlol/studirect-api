<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'email',
        'password'
    ];

    public function adminlogs(): HasMany
    {
        return $this->HasMany(AdminLog::class);
    }
}
