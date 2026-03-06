<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendars';

    protected $fillable = [
        'date',
        'is_open',
        'is_special',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date'       => 'date',
        'is_open'    => 'boolean',
        'is_special' => 'boolean',
    ];

    /**
     * Relación: un día tiene muchos bloques horarios.
     */
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

}
