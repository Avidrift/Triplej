<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    public function literacy_hours(): HasMany
    {
        return $this->hasMany(Literacy_Hour::class);
    }

    public function company(): BelongsTo 
    {
        return $this->belongsTo(Company::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }
}
