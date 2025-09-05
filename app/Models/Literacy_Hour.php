<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Literacy_Hour extends Model
{
    // Especificar el nombre exacto de la tabla
    protected $table = 'literacy_hours'; // Cambia esto por el nombre real de tu tabla
    
    protected $fillable = [
        'id_student',
        'id_teacher',
        'id_zone',
        'date_time_start',
        'date_time_end',
        'comments',
        'hour_type',
        'validated',
    ];

    protected $casts = [
        'date_time_start' => 'datetime',
        'date_time_end' => 'datetime',
        'validated' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_student');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'id_zone');
    }

    // Accessor para obtener la duración en horas
    public function getDurationHoursAttribute(): float
    {
        if ($this->date_time_start && $this->date_time_end) {
            $start = \Carbon\Carbon::parse($this->date_time_start);
            $end = \Carbon\Carbon::parse($this->date_time_end);
            return round($end->diffInMinutes($start) / 60, 1);
        }
        return 0;
    }

    // Accessor para el tipo de hora formateado
    public function getHourTypeFormattedAttribute(): string
    {
        return $this->hour_type === 'school' ? 'Colegio' : 'Aprendizaje Autónomo';
    }
}