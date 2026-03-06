<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'pet_id',
        'service_id',
        'block_id',
        'date',
        'reason',
        'service_id',
        'active',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
