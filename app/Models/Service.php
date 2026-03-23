<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// gano el santos
class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'active'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
