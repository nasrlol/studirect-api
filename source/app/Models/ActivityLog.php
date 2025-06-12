<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;
    public  $timestamps = true;
    
    protected $fillable = [
        'actor_type',
        'actor_id',
        'action',
        'target_type',
        'target_id',
        'severity',
        'created_at',
    ];


    public function actor()
    {
        return $this->morphTo();
    }
    public function target()
    {
        return $this->morphTo();
    }
    

}
