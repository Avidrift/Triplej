<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function literacy_hours(): HasMany
    {
        return $this->hasMany(Literacy_Hour::class);
    }
}
