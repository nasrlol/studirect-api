<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;


class Student extends Model
{
    use HasFactory;

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
    ];

    // wachtwoord mag niet als plain tekst worden opgeslagen dus hashen

    public function setPasswordAttribute($value)
    {
        // hashen enkel wanneer het nog niet gehashed is
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;

        // Altijd hashen om zeker te zijn
        // wordt dan het gehashed ook niet gehashed?
        //$this->attributes['password'] = Hash::make($value);
    }



    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Een student kan meerdere matches/connecties hebben
    public function connecties(): HasMany
    {
        return $this->hasMany(Connection::class);
    }

    public function diploma(): HasMany
    {
        return $this->hasMany(Diploma::class, 'graduation_track');
    }
}
