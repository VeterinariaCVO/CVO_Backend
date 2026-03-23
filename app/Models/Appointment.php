<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'pet_id',
        'time_slot_id',
        'service',
        'status',
        'notes',
        'created_by'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
