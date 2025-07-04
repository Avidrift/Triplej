@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Solicitudes de Horas Pendientes</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Zona</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pending as $hour)
            <tr>
                <td>{{ $hour->student->name ?? '' }}</td>
                <td>{{ $hour->zone->name ?? '' }}</td>
                <td>{{ $hour->date_time_start }}</td>
                <td>{{ $hour->date_time_end }}</td>
                <td>{{ $hour->comments }}</td>
                <td>
                    <form method="POST" action="{{ route('literacy_hours.approve', $hour->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Aprobar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
