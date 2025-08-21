<?php

namespace App\Filament\Resources\LiteracyHourResource\Pages;

use App\Filament\Resources\LiteracyHourResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLiteracyHour extends CreateRecord
{
    protected static string $resource = LiteracyHourResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asignar el profesor según la zona seleccionada
        if (empty($data['id_teacher']) && !empty($data['id_zone'])) {
            $zone = \App\Models\Zone::find($data['id_zone']);
            if ($zone && $zone->teacher) {
                $data['id_teacher'] = $zone->teacher->id;
            }
        }
        return $data;
    }
}
