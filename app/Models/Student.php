<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Student extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'document',
        'email',
        'password',
        'grade',
        'star_date',
        'completed_service',
        'status',
 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'start_date' => 'date',
            'completed_service' => 'boolean',
        ];
    }

    // Implementación de FilamentUser para controlar acceso al panel
    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'student' && $this->status === 'active';
    }

    // Relaciones
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_usuario_admin');
    }

    public function literacy_hours(): HasMany
    {
        return $this->hasMany(Literacy_Hour::class, 'id_student');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }

    // Métodos helper
    public function getNombreCompletoAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function getEstadoServicioAttribute(): string
    {
        return $this->completed_service ? 'Completado' : 'En proceso';
    }
}
