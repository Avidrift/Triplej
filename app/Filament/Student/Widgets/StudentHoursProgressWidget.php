<?php

namespace App\Filament\Student\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use App\Models\Literacy_Hour;
use Carbon\Carbon;

class StudentHoursProgressWidget extends Widget
{
    protected static string $view = 'filament.student.widgets.student-hours-progress';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $student = Auth::user();

        if (!$student) {
            return [
                'totalHours' => 0,
                'schoolHours' => 0,
                'learningHours' => 0,
                'totalRequired' => 120,
                'schoolRequired' => 80,
                'learningRequired' => 40,
                'progressPercentage' => 0,
                'schoolProgressPercentage' => 0,
                'learningProgressPercentage' => 0,
            ];
        }

        $studentHours = Literacy_Hour::where('id_student', $student->id)->get();

        // Calcular horas por tipo
        $schoolHours = $studentHours->where('hour_type', 'school')->sum(function ($hour) {
            $start = Carbon::parse($hour->date_time_start);
            $end = Carbon::parse($hour->date_time_end);
            return round(abs($end->diffInMinutes($start) / 60), 1);
        });

        $learningHours = $studentHours->where('hour_type', 'learning')->sum(function ($hour) {
            $start = Carbon::parse($hour->date_time_start);
            $end = Carbon::parse($hour->date_time_end);
            return round(abs($end->diffInMinutes($start) / 60), 1);
        });

        // Total de horas
        $totalHours = $schoolHours + $learningHours;

        $progressPercentage = min(100, ($totalHours / 120) * 100);
        $schoolProgressPercentage = min(100, ($schoolHours / 80) * 100);
        $learningProgressPercentage = min(100, ($learningHours / 40) * 100);

        // Debug opcional - solo descomenta si necesitas ver los valores
        // \Log::info('Progress Data:', [
        //     'totalHours' => $totalHours,
        //     'schoolHours' => $schoolHours,
        //     'learningHours' => $learningHours,
        //     'progressPercentage' => $progressPercentage,
        //     'schoolProgressPercentage' => $schoolProgressPercentage,
        //     'learningProgressPercentage' => $learningProgressPercentage,
        // ]);

        return [
            'totalHours' => $totalHours,
            'schoolHours' => $schoolHours,
            'learningHours' => $learningHours,
            'totalRequired' => 120,
            'schoolRequired' => 80,
            'learningRequired' => 40,
            'progressPercentage' => round($progressPercentage, 1),
            'schoolProgressPercentage' => round($schoolProgressPercentage, 1),
            'learningProgressPercentage' => round($learningProgressPercentage, 1),
        ];
    }

    public static function canView(): bool
    {
        // Solo mostrar a usuarios autenticados (estudiantes)
        return Auth::check();
    }
}