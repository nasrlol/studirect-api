<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    // zodat de seeding zou werken moet je de factory functie implementeren
    use HasFactory, HasApiTokens;

    // Deze velden mogen ingevuld worden via mass-assignment
    protected $hidden = ['password'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'plan_type',
        'job_types',
        'job_domain',
        'booth_location',
        'photo',
        'speeddate_duration',
        'company_description',
        'job_title',
        'job_requirements',
        'job_description',
        'company_location',
    ];

    // Relatie: een bedrijf kan meerdere afspraken hebben
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Relatie: een bedrijf kan meerdere matches hebben
    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
