@php
    $totalHoras = 0;
    foreach ($hours as $h) {
        $inicio = \Carbon\Carbon::parse($h->date_time_start);
        $fin = \Carbon\Carbon::parse($h->date_time_end);
        $diff = $fin->diffInHours($inicio);
        $totalHoras += $diff > 0 ? $diff : 0;
    }
    $porcentaje = $totalRequired > 0 ? max(0, round(($totalHoras / $totalRequired) * 100, 1)) : 0;
    $user = auth()->user();
    $isTeacher = $user instanceof \App\Models\Teacher;
    $isStudent = $user instanceof \App\Models\Student;
@endphp

<x-filament::page>
    <h2>Hoja de Alfabetización de {{ $student->nombre_completo }}</h2>
    <div class="mb-4">
        <strong>Progreso:</strong> {{ $totalHoras }} / {{ $totalRequired }} horas ({{ $porcentaje }}%)
        <div style="background: #e5e7eb; border-radius: 6px; height: 24px; width: 100%; overflow: hidden;">
            <div style="background: #3b82f6; height: 100%; width: {{ $porcentaje }}%; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                {{ $porcentaje }}%
            </div>
        </div>
    </div>
    @if($isTeacher || $isStudent)
        <a href="{{ route('literacy_hours.student.create', ['student' => $student->id]) }}" class="filament-button filament-button--primary mb-4">Añadir hora</a>
    @endif
    <table class="table-auto w-full mb-4">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Zona</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Descripción</th>
                <th>Validado</th>
                @if($isTeacher)
                    <th>Acción</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($hours as $hour)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($hour->date_time_start)->format('d/m/Y') }}</td>
                    <td>{{ $hour->zone->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($hour->date_time_start)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($hour->date_time_end)->format('H:i') }}</td>
                    <td>{{ $hour->comments }}</td>
                    <td>
                        @if($hour->validated)
                            <span class="text-green-600 font-bold">✔</span>
                        @else
                            <span class="text-red-600 font-bold">✗</span>
                        @endif
                    </td>
                    @if($isTeacher)
                        <td>
                            @if(!$hour->validated)
                                <form method="POST" action="{{ route('literacy_hours.approve', $hour->id) }}">
                                    @csrf
                                    <button type="submit" class="filament-button filament-button--success">Validar</button>
                                </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::page>
