<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $fillable = [
        'type',
    ];

    public function student(){
       return $this->hasMany(Student::class, 'graduation_track');
    }
}
