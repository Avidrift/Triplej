<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class Teacher extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'document',
        'email',
        'password',
        'area',
        'entry_date',
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
            'entry_date' => 'date',
        ];
    }

    // Implementación de FilamentUser para controlar acceso al panel
    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'teacher' && $this->status === 'active';
    }

    // Relaciones
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_usuario_admin');
    }

    public function literacy_hours(): HasMany
    {
        return $this->hasMany(Literacy_Hour::class, 'id_teacher');
    }

    // Relación con estudiantes (asumiendo que hay una tabla pivote teacher_student o campo group_id)
    public function students()
    {
        // Si tienes una tabla pivote teacher_student:
        // return $this->belongsToMany(Student::class, 'teacher_student', 'teacher_id', 'student_id');
        // Si los estudiantes tienen un campo group_id y el maestro también:
        // return Student::where('group_id', $this->group_id);
        // Por ahora, ejemplo con todos los estudiantes:
        return Student::query();
    }

    // Métodos helper
    public function getNombreCompletoAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function getAñosServicioAttribute(): int
    {
        return $this->entry_date ? 
               now()->diffInYears($this->entry_date) : 0;
    }
    public function getFilamentName(): string
{
    return "{$this->name} {$this->last_name}";
}
}

