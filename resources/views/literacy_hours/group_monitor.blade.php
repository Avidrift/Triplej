@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Monitoreo de Grupos</h2>
    @foreach($groups as $group)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Zona:</strong> {{ $group->name }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($group->students as $student)
                        <li>
                            {{ $student->name }} - Horas: {{ $student->literacyHours->where('validated', true)->count() }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
