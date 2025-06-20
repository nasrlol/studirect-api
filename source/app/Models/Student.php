<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;


class Student extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'study_direction',
        'graduation_track',
        'interests',
        'job_preferences',
        'cv',
        'profile_complete',
        'profile_photo',
    ];

    // wachtwoord mag niet als plain tekst worden opgeslagen dus hashen

    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Een student kan meerdere matches/connecties hebben
    public function connection(): HasMany
    {
        return $this->hasMany(Connection::class);
    }

    public function diploma(): BelongsTo
    {
        return $this->belongsTo(Diploma::class, 'graduation_track');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
