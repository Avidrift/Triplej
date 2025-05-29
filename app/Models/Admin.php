<?php
// App/Models/Admin.php (hereda de User)
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends User
{
    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope('admin', function ($builder) {
            $builder->where('role', 'admin');
        });
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'admin_id');
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'admin_id');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'admin_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'admin_id');
    }
}