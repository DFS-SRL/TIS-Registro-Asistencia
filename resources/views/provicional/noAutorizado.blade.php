@extends('layouts.master')

@section('title', 'No Autorizado!')

@section('content')
    <div class="container">
        <h2 class="text-white">
            Lo sentimos, no tienes permiso para acceder a esta dirección. :(
        </h2>
        <img src="/icons/caraTriste.png" class="rounded mx-auto d-block" alt="Responsive image"
        style="max-height: 360px; max-width: auto;">
    </div>
@endsection