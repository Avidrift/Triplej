<?php

namespace App\Filament\Resources\LiteracyHourResource\Pages;

use App\Filament\Resources\LiteracyHourResource;
use App\Models\Zone;
use App\Models\Student;
use Filament\Resources\Pages\Page;
use Filament\Facades\Filament;

class GroupStudentList extends Page
{
    protected static string $resource = LiteracyHourResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Hojas por Grupo';
    protected static ?string $title = 'Selecciona un Grupo';
    protected static string $view = 'filament.resources.literacy-hour-resource.pages.group-student-list';

    public $zones;
    public $selectedZone = null;
    public $students = [];

    public function mount(): void
    {
        $user = Filament::auth()?->user();
        // Aquí puedes filtrar solo los grupos del profesor si tienes esa relación
        $this->zones = Zone::all();
        if (request()->has('zone')) {
            $this->selectedZone = request('zone');
            $this->students = Student::where('status', 'active')->where('zone_id', $this->selectedZone)->get();
        }
    }
}
