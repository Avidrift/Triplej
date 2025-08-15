<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Selecciona un Grupo</h2>
    <form method="GET" class="mb-6">
        <select name="zone" class="filament-input" onchange="this.form.submit()">
            <option value="">-- Selecciona una zona --</option>
            @foreach($zones as $zone)
                <option value="{{ $zone->id }}" @if($selectedZone == $zone->id) selected @endif>{{ $zone->name }}</option>
            @endforeach
        </select>
    </form>
    @if($selectedZone && count($students))
        <h3 class="font-semibold mb-2">Estudiantes del grupo</h3>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Progreso</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        $totalHoras = $student->literacy_hours->sum(function($h) {
                            $inicio = \Carbon\Carbon::parse($h->date_time_start);
                            $fin = \Carbon\Carbon::parse($h->date_time_end);
                            $diff = $fin->diffInHours($inicio);
                            return $diff > 0 ? $diff : 0;
                        });
                        $totalRequired = 20;
                        $porcentaje = $totalRequired > 0 ? max(0, round(($totalHoras / $totalRequired) * 100, 1)) : 0;
                    @endphp
                    <tr>
                        <td>{{ $student->nombre_completo }}</td>
                        <td>
                            <div style="background: #e5e7eb; border-radius: 6px; height: 18px; width: 100px; overflow: hidden;">
                                <div style="background: #3b82f6; height: 100%; width: {{ $porcentaje }}%; color: white; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ $porcentaje }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ \App\Filament\Resources\LiteracyHourResource::getUrl('student-sheet', ['record' => $student->id]) }}" class="filament-button filament-button--primary">Ver hoja</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($selectedZone)
        <div class="text-gray-500">No hay estudiantes en este grupo.</div>
    @endif
</x-filament::page>
