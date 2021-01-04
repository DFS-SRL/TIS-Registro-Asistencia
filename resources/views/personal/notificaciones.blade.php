
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
                @foreach ($notificaciones as $key => $noti)
                    <li class="list-group-item 
                    {{ $noti->leida() ? 'list-group-item-dark' : 'list-group-item-info'}}">
                        <a href="{{ $noti->link }}" onclick="$('#form-{{$key}}').submit()">
                            {{ $noti->text }}
                        </a>
                        <div class="float-right">
                            @if (!$noti->leida())
                                <form id="form-{{ $key }}" class="float-right ml-2" action="{{ route('notificaciones.leer', $noti->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button class="btn btn-danger">X</button>
                                </form>
                            @endif
                            {{ \Carbon\Carbon::parse($noti->created_at)->format('d/m/Y H:i')}}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="mt-2 d-flex justify-content-center">
            {{ $notificaciones->links() }}
        </div>
    </div>
@endsection