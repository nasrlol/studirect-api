<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{

    // zodat de seeding zou werken moet je de factory functie implementeren
    use HasFactory;
    // Velden die massaal ingevuld mogen worden (via create of update)
    protected $fillable = [
        'student_id',
        'company_id',
        'time_slot',
    ];

    // Relatie: een appointment hoort bij één student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Relatie: een appointment hoort bij één bedrijf
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
