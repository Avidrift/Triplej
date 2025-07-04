@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Registrar Hora (Estudiante)</h2>
    <form method="POST" action="{{ route('literacy_hours.student.store') }}">
        @csrf
        <div class="mb-3">
            <label for="id_zone" class="form-label">Zona</label>
            <select name="id_zone" id="id_zone" class="form-control" required>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date_time_start" class="form-label">Fecha y hora de inicio</label>
            <input type="datetime-local" name="date_time_start" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date_time_end" class="form-label">Fecha y hora de fin</label>
            <input type="datetime-local" name="date_time_end" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="comments" class="form-label">Descripción (opcional)</label>
            <textarea name="comments" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar para aprobación</button>
    </form>
</div>
@endsection
