@extends('layouts.master')

@section('title', 'Cambio Contraseña')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card w-50">
                <div class="card-header">
                    <h3>Cambio de Contraseña</h3>
                </div>

                <form id="reset-form" action="/reset-password" method="post">
                    @csrf
                    <div class="input-group form-group">
                        <div class="input-group form-group">
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Nueva Contraseña">
                        </div>
                        <div class="input-group form-group">
                            <input type="password" class="form-control" id="repeat-password" name="repeat_password" placeholder="Repite la Contraseña">
                        </div>
                        <label id="message" for="repeat_password" class=" text-danger d-none"></label>
                    </div>
                    <div class="form-group text-center">
                      <input type="button" onclick="validate()" class="btn btn-primary" value="Cambiar Contraseña">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/provisional/reset-password.js"></script>
@endsection