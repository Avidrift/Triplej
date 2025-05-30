<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
     protected $fillable  = [
        'nombres',
        'apellidos',
        'documento',
        'grado',
        'fecha_inicio',
        'servicio_completado',
        'id_usuario_admin',
    ];


    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function literacy_hours(): HasMany
    {
        return $this->hasMany(Literacy_Hour::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}
