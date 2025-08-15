<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\Widget;
use Filament\Facades\Filament;

class StudentSheetLinkWidget extends Widget
{
    protected static string $view = 'filament.student.widgets.student-sheet-link-widget';
    protected static ?int $sort = 1;

    public function getStudentSheetUrl(): string
    {
        $user = Filament::auth()?->user();
        if ($user && $user instanceof \App\Models\Student) {
            return \App\Filament\Resources\LiteracyHourResource::getUrl('student-sheet', ['record' => $user->id]);
        }
        return '#';
    }
}
