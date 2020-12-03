@extends('layouts.master')
@section('title', 'Registro de personal academico')

@section('content')
    <div class="container">
        <h3 class="textoBlanco">Facultad: {{ $unidad->facultad }}</h3>
        <h3 class="textoBlanco">Departamento: {{ $unidad->nombre }}</h3>
        <br>
        <h3 class="text-center textoBlanco">Registrar Personal Academico </h3>
        <div class="row justify-content-center my-4">
            <form method="GET" action="{{route('personalAcademico.verificar',$unidad->id)}}" onsubmit="return validarSoloNumeros('codsis','mensaje') && validarNoVacio('codsis')">
                @csrf
                <div class="col-12 opciones esquina-redondeada cafe">
                    <div class="form-inline m-2">
                        @if ($despuesVerificar)
                            <span class="textoBlanco mr-2">Codigo SIS: </span> <input type="text" class="form-control" name="codsis" value="{{$codSis}}" disabled>
                            <button type="submit" class="btn boton ml-2" disabled>VERIFICAR</button>
                        @else
                            <span class="textoBlanco mr-2">Codigo SIS: </span> <input type="text" id="codsis" class="form-control" name="codsis">
                            <button type="submit" class="btn boton ml-2">VERIFICAR</button>
                        @endif
                    </div>
                        <p id="mensaje"class="textoBlanco ml-1"></p>
                </div>
            </form>
        </div> 
        <div class="mx-5 mt-3">
            <form method="POST" action="{{route('personalAcademico.registrar',$unidad->id)}}" id="formulario" class="mx-5" onsubmit="return validarCamposNoVacios(this.id)">
                @csrf
                @if ($despuesVerificar)
                    @if ($nombres == "")
                        <div class="row justify-content-center">
                            <p id="mensajeFormulario" class="textoBlanco"></p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Nombres: </span>
                            </div>
                            <div class="col-4">
                                <input id="nombres" type="text" class="form-control mb-4 " name="nombres">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido paterno: </span>
                            </div>
                            <div class="col-4">
                                <input id="paterno" type="text" class="form-control mb-4" name="apellidoPaterno">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido materno: </span>
                            </div>
                            <div class="col-4">
                                <input id="materno" type="text" class="form-control mb-4 " name="apellidoMaterno">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Correo electronico: </span>
                            </div>
                            <div class="col-4">
                                <input id="correo" type="email" class="form-control mb-4 " name="correo">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Roles: </span>
                            </div>
                            <div class="col-4">
                                <div class="form-check" >
                                    <input class="form-check-input " type="checkbox" value="" id="docente" onclick="verificarCheckBoxes('docente')" name="docente">
                                    <label class="form-check-label textoBlanco">
                                    Docente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" value="" id="auxDocencia" onclick="verificarCheckBoxes('auxDocencia')" name="auxDoc">
                                    <label class="form-check-label textoBlanco">
                                    Auxiliar de docencia
                                    </label>
                                </div>
                                <div class="form-check"> 
                                    <input class="form-check-input " type="checkbox" value="" id="auxLaboratorio" onclick="verificarCheckBoxes('auxLaboratorio')" name="auxLab">
                                    <label class="form-check-label textoBlanco" >
                                    Auxiliar de laboratorio
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mt-4">
                            <button type="submit" class="btn boton mr-5 ">REGISTRAR</button>
                            <button class="btn btn-danger ">CANCELAR</button>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Nombres: </span>
                            </div>
                            <div class="col-4">
                                <input id="nombres" type="text" class="form-control mb-4 " value="{{$nombres}}" name = "nombres" readonly>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido paterno: </span>
                            </div>
                            <div class="col-4">
                                <input id="paterno" type="text" class="form-control mb-4 " value="{{$apellidoPaterno}}" name="apellidoPaterno" readonly>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Apellido materno: </span>
                            </div>
                            <div class="col-4">
                                <input id="materno" type="text" class="form-control mb-4 " value="{{$apellidoMaterno}}" name="apellidoMaterno" readonly>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Correo electronico: </span>
                            </div>
                            <div class="col-4">
                                <input id="correo" type="email" class="form-control mb-4 " value="{{$correo}}" name="correo" readonly>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <span class="textoBlanco mr-2">Roles: </span>
                            </div>
                            <div class="col-4">
                                <div class="form-check" >
                                    <input class="form-check-input " type="checkbox" value="" id="docente" onclick="verificarCheckBoxes('docente')" name="docente" @if ($perteneceDepartamento) readonly @if(in_array('3',$roles)) checked @endif @endif>
                                    <label class="form-check-label textoBlanco">
                                    Docente
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" value="" id="auxDocencia" onclick="verificarCheckBoxes('auxDocencia')" name="auxDoc" @if ($perteneceDepartamento) readonly @if(in_array('2',$roles)) checked @endif @endif>
                                    <label class="form-check-label textoBlanco">
                                    Auxiliar de docencia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" value="" id="auxLaboratorio" onclick="verificarCheckBoxes('auxLaboratorio')" name="auxLab" @if ($perteneceDepartamento) readonly @if(in_array('1',$roles)) checked @endif @endif>
                                    <label class="form-check-label textoBlanco" >
                                    Auxiliar de laboratorio
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mt-4">
                            @if ($perteneceDepartamento)
                                <button class="btn boton">EDITAR</button>
                            @else
                                <button type="submit" class="btn boton mr-5 ">REGISTRAR</button>
                                <button class="btn btn-danger">CANCELAR</button>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Nombres: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 " disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Apellido paterno: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 " disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Apellido materno: </span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control mb-4 " disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Correo electronico: </span>
                        </div>
                        <div class="col-4">
                            <input type="email" class="form-control mb-4 " disabled>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-3">
                            <span class="textoBlanco mr-2">Roles: </span>
                        </div>
                        <div class="col-4">
                            <div class="form-check" >
                                <input class="form-check-input " type="checkbox" value="" id="docente" disabled onclick="verificarCheckBoxes('docente')">
                                <label class="form-check-label textoBlanco">
                                Docente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" value="" id="auxDocencia" disabled onclick="verificarCheckBoxes('auxDocencia')">
                                <label class="form-check-label textoBlanco">
                                Auxiliar de docencia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" value="" id="auxLaboratorio" disabled onclick="verificarCheckBoxes('auxLaboratorio')">
                                <label class="form-check-label textoBlanco" >
                                Auxiliar de laboratorio
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center mt-4">
                        <button type="submit" class="btn boton mr-5 " disabled>REGISTRAR</button>
                        <button class="btn btn-danger " disabled>CANCELAR</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    @section('script-footer')
        <script type="text/javascript" src="/js/informacion/registrarPersonalAcademico.js"></script>
    @endsection
@endsection