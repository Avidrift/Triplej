<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function zone (): HasMany
    {
        return $this->hasMany(Zone::class);
    }
}
