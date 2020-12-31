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
                            <input type="password" id="pwd" class="form-control" name="password" placeholder="Constraseña">
                        </div>
                        <div class="input-group form-group form-check textoBlanco">
                            <input type="checkbox" onclick="revelar()" name="revelar_check">
                            <label class="form-check-label" for="revelar_check">
                               Mostrar Contraseña
                            </label>
                        </div>
                        <div class="input-group form-group form-check textoBlanco">
                            <input type="checkbox" name="remember_me">
                            <label class="form-check-label" for="remember_me">
                              Recuerdame
                            </label>
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

@section('script-footer')
    <script>
        function revelar() {
            var x = document.getElementById("pwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection