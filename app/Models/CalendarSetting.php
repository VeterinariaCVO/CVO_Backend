<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarSetting extends Model
{
    // Si usas factories luego:
    // use HasFactory;

    protected $table = 'calendar_settings';

    protected $fillable = [
        'company_id',
        'block_duration',
        'start_time',
        'end_time',
        'working_days',
        'is_active',
    ];

    protected $casts = [
        'block_duration' => 'integer',
        'is_active'      => 'boolean',
    ];

    /**
     * Devuelve los días laborales como array: ['mon', 'tue', ...]
     */
    public function getWorkingDaysArrayAttribute(): array
    {
        if (empty($this->working_days)) {
            return [];
        }

        return explode(',', $this->working_days);
    }

    // Si después tienes un modelo Company, puedes descomentar esto:
    /*
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    */
}
