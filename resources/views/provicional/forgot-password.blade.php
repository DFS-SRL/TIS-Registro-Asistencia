@extends('layouts.master')

@section('title', '¿Olvidaste tu contraseña?')

@section('css')
    <link rel="stylesheet" href="/css/auth/login.css">
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card w-50">
                <div class="card-header">
                    <h3>¿Olvidaste tu Contraseña?</h3>
                </div>
                <div class="card-body">
                    <form id="forgot-form" action="/forgot-password" method="post">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group form-group">
                                <input type="password" class="form-control" id="codSis" name="codSis" placeholder="Codigo SIS">
                            </div>
                        </div>
                        <div class="form-group text-center">
                          <input type="button" onclick="$('#forgot-form').submit();" class="btn btn-primary" value="Enviar correo">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links text-justify">
                        Se enviará instrucciones para el cambio de contraseña, por favor, verifica el correo electrónico asociado al código sis ingresado.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-footer')
    {{-- <script src="/js/provisional/reset-password.js"></script> --}}
@endsection