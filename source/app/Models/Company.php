<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Company extends Model
{
    // zodat de seeding zou werken moet je de factory functie implementeren
    use HasFactory;

    // Deze velden mogen ingevuld worden via mass-assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'plan_type',
        'description',
        'job_types',
        'job_domain',
        'booth_location',
        'photo',
        'speeddate_duration',
        'company_description',
        'job_requirements',
        'job_description',
    ];


    // zelfde als bij student het wachtwoord mag niet als plain tekst worden
    // opgeslagen dus we hashen het

    public function setPasswordAttribute($value)
    {
        // hashen enkel wanneer het nog niet gehashed is
        /*if (!Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;*/

        // Altijd hashen om zeker te zijn
        $this->attributes['password'] = Hash::make($value);
    }

    // Relatie: een bedrijf kan meerdere afspraken hebben
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Relatie: een bedrijf kan meerdere matches hebben
    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class);
    }
}
