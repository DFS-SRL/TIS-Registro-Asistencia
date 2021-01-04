
@extends('layouts.master')
@section('title', 'Notificaciones')
@section('css')

@endsection
@section('content')
    <div class="container">
    @if ($notificacionesLeidas->isEmpty() && $notificacionesNoLeidas->isEmpty())
            <h4 class='textoBlanco'>No ha recibido ninguna notificacion de momento</h4>
        @else
        <ul class="list-group">
                @foreach ($notificacionesNoLeidas as $noti)
                    <li class="list-group-item list-group-item-info">
                        <a href="{{ $noti->link }}">
                            {{ $noti->text }}
                        </a>
                        <div class="float-right">
                            <form class="float-right" action="{{ route('notificaciones.leer', $noti->id) }}" method="POST">
                                {{-- {{ method_field('PATCH') }} --}}
                                @method('PATCH')
                                @csrf
                                <button class="btn btn-danger boton">X</button>
                            </form>
                            {{ \Carbon\Carbon::parse($noti->created_at)->format('d/m/Y H:i')}}
                        </div>
                    </li>
                @endforeach

                @foreach ($notificacionesLeidas as $noti)
                    <li class="list-group-item list-group-item-dark">
                        <a href="{{ $noti->link }}">
                            {{ $noti->text }}
                        </a>
                        <div class="float-right">
                            {{ \Carbon\Carbon::parse($noti->created_at)->format('d/m/Y h:m')}}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection