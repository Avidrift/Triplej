<?php

namespace App\Filament\Resources\LiteracyHourResource\Pages;

use App\Filament\Resources\LiteracyHourResource;
use App\Models\Literacy_Hour;
use App\Models\Student;
use Filament\Resources\Pages\Page;

class StudentSheet extends Page
{
    protected static string $resource = LiteracyHourResource::class;
    public Student $student;
    public $hours;
    public $totalRequired = 20; // Cambia según tu requerimiento

    public function mount($record): void
    {
        $this->student = Student::findOrFail($record);
        $this->hours = Literacy_Hour::where('id_student', $this->student->id)->orderBy('date_time_start')->get();
    }

    public function getView(): string
    {
        return 'filament.resources.literacy-hour-resource.pages.student-sheet';
    }
}
