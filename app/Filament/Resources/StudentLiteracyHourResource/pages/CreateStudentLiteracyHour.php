<?php

namespace App\Filament\Resources\StudentLiteracyHourResource\Pages;

use App\Filament\Resources\StudentLiteracyHourResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentLiteracyHour extends CreateRecord
{
    protected static string $resource = StudentLiteracyHourResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-asigna el estudiante logueado
        $data['id_student'] = \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : null;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Redirige al listado después de crear
        return $this->getResource()::getUrl('index');
    }
}

