@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Mi Avance</h2>
    <div class="alert alert-info">
        Horas validadas: <strong>{{ $total }}</strong>
    </div>
    <!-- Aquí puedes agregar una barra de progreso o predicción si lo deseas -->
</div>
@endsection
