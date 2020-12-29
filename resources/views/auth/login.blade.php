@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/auth/login.css">
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Iniciar Sesion</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="/login">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text justify-content-center"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="usuario_codSis" placeholder="Codigo sis" value={{old('usuario_codSis')}}>

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text justify-content-center"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Constraseña">
                        </div>
                        <div class="form-group text-center">
                          <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links text-justify">
                        En caso de no tener cuenta, contacte con el jefe de su departamento.
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/forgot-password">¿Olvidaste la contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
