<?php

namespace App\Filament\Resources\StudentLiteracyHourResource\Pages;

use App\Filament\Resources\StudentLiteracyHourResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditStudentLiteracyHour extends EditRecord
{
    protected static string $resource = StudentLiteracyHourResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['id_student'] = Auth::check() ? Auth::id() : null;
        return $data;
    }

    protected function canDelete(): bool
    {
        // Solo permite eliminar si no está validada
        return !$this->record->validated;
    }

    protected function canEdit(): bool
    {
        // Solo permite editar si no está validada
        return !$this->record->validated && $this->record->id_student === (Auth::user() ? Auth::user()->id : null);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
