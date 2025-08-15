<?php

namespace App\Filament\Resources\StudentLiteracyHourResource\Pages;

use App\Filament\Resources\StudentLiteracyHourResource;
use Filament\Resources\Pages\ListRecords;

class ListStudentLiteracyHours extends ListRecords
{
    protected static string $resource = StudentLiteracyHourResource::class;

    public function getTitle(): string
    {
        return 'Mis Horas de Alfabetización';
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Solo muestra las horas del estudiante logueado usando el guard correcto
        $studentId = auth('student')->id();
        return parent::getTableQuery()->where('id_student', $studentId);
    }

    protected function canCreate(): bool
    {
        return true;
    }
}
