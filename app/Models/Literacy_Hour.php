<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Literacy_Hour extends Model
{
    protected $table = 'literacy_hours'; 
    
    protected $fillable = [
        'id_zone',
        'id_student', 
        'id_teacher',
        'date_time_start',
        'date_time_end',
        'validated',
        'comments'
    ];

    protected $attributes = [
        'validated' => false,
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
}