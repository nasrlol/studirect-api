<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Diploma extends Model
{
    protected $fillable = [
        'type',
    ];

    public function student(): HasMany
    {
       return $this->hasMany(Student::class, 'graduation_track');
    }
}
