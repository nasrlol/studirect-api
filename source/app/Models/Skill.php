<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The students that have this skill.
     */
    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * The companies that require this skill.
     */
    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
