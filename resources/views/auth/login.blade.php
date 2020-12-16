@extends('layouts.master')

@section('content')
    <form method="POST" action="/login" >
      @csrf
      <input type="text" name="usuario_codSis" placeholder="Codigo sis">
      <input type="password" name="password" placeholder="Constraseña">
      <input type="submit" value="ENTRAR">
    </form>
@endsection
