<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Zone;
use App\Models\Company;

class ZoneTeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Crear una empresa de prueba si no existe
        $company = Company::firstOrCreate([
            'name' => 'Empresa Demo'
        ], [
            'owner' => 'Admin Demo',
        ]);

        // Crear profesores de prueba
        $teacher1 = Teacher::firstOrCreate([
            'email' => 'profesor1@demo.com'
        ], [
            'name' => 'Juan',
            'last_name' => 'Pérez',
            'document' => '12345678',
            'password' => bcrypt('password'),
            'area' => 'Matemáticas',
            'entry_date' => now(),
            'status' => 'active',
        ]);
        $teacher2 = Teacher::firstOrCreate([
            'email' => 'profesor2@demo.com'
        ], [
            'name' => 'Ana',
            'last_name' => 'García',
            'document' => '87654321',
            'password' => bcrypt('password'),
            'area' => 'Lengua',
            'entry_date' => now(),
            'status' => 'active',
        ]);

        // Crear zonas de prueba ligadas a profesores
        Zone::firstOrCreate([
            'name' => 'Zona Norte'
        ], [
            'id_company' => $company->id,
            'id_teacher' => $teacher1->id,
            'description' => 'Zona asignada a Juan Pérez',
            'status' => 'active',
        ]);
        Zone::firstOrCreate([
            'name' => 'Zona Sur'
        ], [
            'id_company' => $company->id,
            'id_teacher' => $teacher2->id,
            'description' => 'Zona asignada a Ana García',
            'status' => 'active',
        ]);
    }
}
