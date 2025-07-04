<?php

namespace App\Filament\Resources\LiteracyHourResource\Pages;

use Filament\Pages\Page;
use Filament\Facades\Filament;

class StudentDashboardLink extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Mi Hoja de Alfabetización';
    protected static ?string $title = 'Mi Hoja de Alfabetización';
    protected static string $view = 'filament.resources.literacy-hour-resource.pages.student-dashboard-link';

    public function mount(): void
    {
        $user = \Filament\Facades\Filament::auth()?->user();
        if ($user && $user instanceof \App\Models\Student) {
            header('Location: ' . \App\Filament\Resources\LiteracyHourResource::getUrl('student-sheet', ['record' => $user->id]));
            exit;
        }
    }
}
