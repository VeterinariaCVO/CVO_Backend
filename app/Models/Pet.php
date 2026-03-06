<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name', 'species', 'breed', 'color', 'special_marks',
        'weight', 'sex', 'age', 'photo_path', 'owner_id', 'active'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
