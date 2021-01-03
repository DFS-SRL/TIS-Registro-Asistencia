
@extends('layouts.master')
@section('title', 'Notificaciones')
@section('css')

@endsection
@section('content')
    <div class="container">
        @if ($notificaciones->isEmpty())
            <h4 class='textoBlanco'>No ha recibido ninguna notificacion de momento</h4>
        @else
            <ul class="list-group">
                @foreach ($notificaciones as $noti)
                    <li class="list-group-item">{{ $noti }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection