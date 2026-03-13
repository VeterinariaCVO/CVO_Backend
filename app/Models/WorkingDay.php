<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = [
        'date',
        'is_open'
    ];

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}
