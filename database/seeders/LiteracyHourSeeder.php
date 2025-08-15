<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Zone;
use App\Models\Literacy_Hour;
use Illuminate\Support\Str;

class LiteracyHourSeeder extends Seeder
{
    public function run(): void
    {
        // Crear compañía de ejemplo
        $company = \App\Models\Company::firstOrCreate([
            'name' => 'Compañía Demo',
            'owner' => 'admin@demo.com', // Ajusta el valor según tu lógica
        ]);

        // Crear zonas asociadas a la compañía
        $zoneA = Zone::firstOrCreate([
            'name' => 'Zona A',
            'id_company' => $company->id,
        ]);
        $zoneB = Zone::firstOrCreate([
            'name' => 'Zona B',
            'id_company' => $company->id,
        ]);

        // Crear maestros
        $teacher1 = Teacher::firstOrCreate([
            'email' => 'maestro1@demo.com',
        ], [
            'name' => 'Juan',
            'last_name' => 'Pérez',
            'document' => '123456',
            'password' => bcrypt('password'),
            'area' => 'Lengua',
            'entry_date' => now()->subYears(3),
            'status' => 'active',
        ]);

        // Crear estudiantes
        $student1 = Student::firstOrCreate([
            'email' => 'estudiante1@demo.com',
        ], [
            'name' => 'Ana',
            'last_name' => 'García',
            'document' => '654321',
            'password' => bcrypt('password'),
            'grade' => '9',
            'star_date' => now()->subMonths(6),
            'complete_service' => false,
            'status' => 'active',
        ]);
        $student2 = Student::firstOrCreate([
            'email' => 'estudiante2@demo.com',
        ], [
            'name' => 'Luis',
            'last_name' => 'Martínez',
            'document' => '789012',
            'password' => bcrypt('password'),
            'grade' => '9',
            'star_date' => now()->subMonths(4),
            'complete_service' => false,
            'status' => 'active',
        ]);

        // Crear registros de horas
        Literacy_Hour::create([
            'id_zone' => $zoneA->id,
            'id_student' => $student1->id,
            'id_teacher' => $teacher1->id,
            'date_time_start' => now()->subDays(10)->setTime(8,0),
            'date_time_end' => now()->subDays(10)->setTime(10,0),
            'validated' => true,
            'comments' => 'Alfabetización básica en Zona A',
        ]);
        Literacy_Hour::create([
            'id_zone' => $zoneA->id,
            'id_student' => $student1->id,
            'id_teacher' => $teacher1->id,
            'date_time_start' => now()->subDays(7)->setTime(9,0),
            'date_time_end' => now()->subDays(7)->setTime(11,0),
            'validated' => false,
            'comments' => 'Sesión pendiente de validación',
        ]);
        Literacy_Hour::create([
            'id_zone' => $zoneB->id,
            'id_student' => $student2->id,
            'id_teacher' => $teacher1->id,
            'date_time_start' => now()->subDays(5)->setTime(8,0),
            'date_time_end' => now()->subDays(5)->setTime(10,0),
            'validated' => true,
            'comments' => 'Alfabetización avanzada en Zona B',
        ]);
    }
}
