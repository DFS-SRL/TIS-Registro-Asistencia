@extends('layouts.master')
@section('title', 'Registro de personal academico')

@section('content')
    <div class="container">
        <h3 class="textoBlanco">Facultad: {{ $unidad->facultad }}</h3>
        <h3 class="textoBlanco">Departamento: {{ $unidad->nombre }}</h3>
        <br>
        <h3 class="text-center textoBlanco">Registrar Personal Academico </h3>
        <div class="row justify-content-center my-4">
            <form method="GET" action="{{route('personalAcademico.verificar',$unidad->id)}}">
                @csrf
                <div class="col-12 opciones esquina-redondeada cafe">
                    <div class="form-inline m-2">
                        @if ($despuesVerificar)
                            <span class="textoBlanco mr-2">Codigo SIS: </span> <input type="text" class="form-control" name="codsis" value="{{$codSis}}" disabled>
                            <button type="submit" class="btn boton ml-2" disabled>VERIFICAR</button>
                        @else
                            <span class="textoBlanco mr-2">Codigo SIS: </span> <input type="text" class="form-control" name="codsis">
                            <button type="submit" class="btn boton ml-2">VERIFICAR</button>
                        @endif
                    </div>
                </div>
            </form>
        </div> 
        <div class="mx-5 mt-5">
            <form action="" class="mx-5">
                @if ($despuesVerificar)
                    @if (count($departamento) == 0)
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Nombres: </span>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido paterno: </span>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido materno: </span>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Correo electronico: </span>
                            </div>
                            <div class="col-4">
                                <input type="email" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Roles: </span>
                            </div>
                            <div class="col-4">
                                <div class="form-check" >
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="docente" onclick="verificarCheckBoxes('docente')">
                                    <label class="form-check-label textoBlanco">
                                    Docente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxDocencia" onclick="verificarCheckBoxes('auxDocencia')">
                                    <label class="form-check-label textoBlanco">
                                    Auxiliar de docencia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxLaboratorio" onclick="verificarCheckBoxes('auxLaboratorio')">
                                    <label class="form-check-label textoBlanco" >
                                    Auxiliar de laboratorio
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mt-4">
                            <button type="submit" class="btn boton mr-5 deshabilitado">REGISTRAR</button>
                            <button class="btn btn-danger deshabilitado">CANCELAR</button>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Nombres: </span>
                            </div>
                            <div class="col-4">
                            <input type="text" class="form-control mb-4 deshabilitado" value="{{explode(' ',$personal->nombre)}}">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido paterno: </span>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido materno: </span>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Correo electronico: </span>
                            </div>
                            <div class="col-4">
                                <input type="email" class="form-control mb-4 deshabilitado">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Roles: </span>
                            </div>
                            <div class="col-4">
                                <div class="form-check" >
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="docente" onclick="verificarCheckBoxes('docente')">
                                    <label class="form-check-label textoBlanco">
                                    Docente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxDocencia" onclick="verificarCheckBoxes('auxDocencia')">
                                    <label class="form-check-label textoBlanco">
                                    Auxiliar de docencia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxLaboratorio" onclick="verificarCheckBoxes('auxLaboratorio')">
                                    <label class="form-check-label textoBlanco" >
                                    Auxiliar de laboratorio
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mt-4">
                            <button type="submit" class="btn boton mr-5 deshabilitado">REGISTRAR</button>
                            <button class="btn btn-danger deshabilitado">CANCELAR</button>
                        </div>
                    @endif
                @else
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Nombres: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 deshabilitado" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Apellido paterno: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 deshabilitado" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Apellido materno: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 deshabilitado" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Correo electronico: </span>
                        </div>
                        <div class="col-4">
                            <input type="email" class="form-control mb-4 deshabilitado" disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Roles: </span>
                        </div>
                        <div class="col-4">
                            <div class="form-check" >
                                <input class="form-check-input deshabilitado" type="checkbox" value="" id="docente" disabled onclick="verificarCheckBoxes('docente')">
                                <label class="form-check-label textoBlanco">
                                Docente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxDocencia" disabled onclick="verificarCheckBoxes('auxDocencia')">
                                <label class="form-check-label textoBlanco">
                                Auxiliar de docencia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input deshabilitado" type="checkbox" value="" id="auxLaboratorio" disabled onclick="verificarCheckBoxes('auxLaboratorio')">
                                <label class="form-check-label textoBlanco" >
                                Auxiliar de laboratorio
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mt-4">
                        <button type="submit" class="btn boton mr-5 deshabilitado" disabled>REGISTRAR</button>
                        <button class="btn btn-danger deshabilitado" disabled>CANCELAR</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    @section('script-footer')
        <script type="text/javascript" src="/js/informacion/registrarPersonalAcademico.js"></script>
    @endsection
@endsection