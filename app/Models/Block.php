<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'start_time',
        'end_time',
        'is_active',
        'is_booked',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_booked' => 'boolean',
    ];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
