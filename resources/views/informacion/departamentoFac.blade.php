@extends('layouts.master')

@section('title', 'Informacion Dept')

@section('content')
    <div class="container">
        <div class="row">
                <div class="col-10 ">
                    <h3 class="textoBlanco">FACULTAD: <a class="textoBlanco" href="/facultades/{{ $unidad->facultad->nombre }}">{{ $unidad->facultad->nombre }} </a></h3>
                    <h3 class="textoBlanco">DEPARTAMENTO: <a class="textoBlanco" href="/departamento/{{ $unidad->id }}">{{ $unidad->nombre }}</a></h3>
                    <h3 class="textoBlanco">JEFE DE DEPARTAMENTO: {{$unidad->jefe->nombre}}  </h3> 
                </div>

                     
            <div class="col-12">          
                <br>
                <strong class="textoBlanco">INFORMACION DEL DEPARTAMENTO</strong><br><br>
                <div class="d-flex justify-content-around"> 
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/materias/{{$unidad->id}}'">MATERIAS</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/cargos/{{$unidad->id}}'">CARGOS DE LABORATORIO</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/personalAcademico/{{$unidad->id}}'" >PERSONAL ACADÉMICO</button>
                    @if(Auth::user()->usuario->tienePermisoNombre('registrar personal academico') && Auth::user()->usuario->perteneceAUnidad($unidad->id))
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/personalAcademico/registrar/{{$unidad->id}}'" >REGISTRAR PERSONAL ACADÉMICO</button>
                    @endif
                    @if(Auth::user()->usuario->tienePermisoNombre('ver partes mensuales') && Auth::user()->usuario->perteneceAUnidad($unidad->id))
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/partes/mensuales/{{$unidad->id}}'">BUSCAR PARTE MENSUAL</button>
                    @endif
                    @if(Auth::user()->usuario->tienePermisoNombre('ver informes semanales') && Auth::user()->usuario->perteneceAUnidad($unidad->id))
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/informes/{{$unidad->id}}'">INFORMES SEMANALES</button>
                    @endif
                    
                </div>
                @if (Auth::user()->usuario->tienePermisoNombre('ver partes mensuales') && Auth::user()->usuario->perteneceAUnidad($unidad->id))
                    @if (!$ultimosPartes->isEmpty())
                        <div class="mb-2 mt-5">
                            <strong class="textoBlanco">ULTIMOS PARTES MENSUALES</strong>
                        </div>
                        <div >
                            <table class = "table " id="ultimosPartes">
                                @foreach ($ultimosPartes as $values => $parte)
                                <tr>
                                    <td class="border border-dark"><strong >{{$parte->mes}}</strong></td>
                                    <td class="border border-dark"><a href="/" id="doc{{$parte->id}}">Ver parte docentes</a></td>
                                    <td class="border border-dark"><a href="/" id="aux{{$parte->id}}">Ver parte auxiliares</a></td>
                                    @if($parte->jefe_dept)
                                    <td class="border border-dark">APROBADOS   </td>  
                                    @else
                                        <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                            class="form-inline my-2 my-lg-0 d-inline"
                                            >
                                            @csrf @method('PATCH')
                                            <input type="hidden" name = 'parte_id' value = '{{$parte->id}}'>
                                            <input type="hidden" name = 'rol' value = '4'>
                                        </form>
                                        <td class="border border-dark"><input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR PARTES"></td>
                                    @endif
                                </tr>
                                @endforeach
                            </table>     
                        </div>
                    @else
                        <h3 class="textoBlanco">AÚN NO HAY PARTES MENSUALES DISPONIBLES</h3>
                    @endif
                    </div>
    
                    <div class="col-12">
                        <div class="mb-2 mt-5">
                            <strong class="textoBlanco">PERSONAL QUE NO ENVIÓ SUS ASISTENCIAS EN ESTA SEMANA</strong>
                        </div>
                        @if (!$personal->isEmpty())
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="border-dark col-6" scope="col">Nombre</th>
                                        <th class="border-dark col-6" scope="col">Ítems/Grupos no llenados</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($personal as $p)
                                        <tr>
                                            <td class="border-dark">
                                                {{ $p['usuario']->nombre }}
                                            </td>
                                            <td class="border-dark">
                                                {{ $p['faltas'] }}
                                            </td>
                                            <td class="border-dark">
                                                <form action="/departamento/notificar" method="POST">
                                                    @csrf
                                                    <button class="btn btn-warning boton textoBlanco">Notificar</button>
    
                                                    <input type="text" class="d-none" name="unidad" value={{ $unidad['id'] }}>
                                                    <input type="text" class="d-none" name="personal" value={{ $p['usuario']->codSis }}>
                                                    <input type="text" class="d-none" name="jefe" value={{ auth()->user()->usuario->codSis }}>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2 d-flex justify-content-center">
                                {{ $personal->links() }}
                            </div>
                        @else
                            <h3 class="textoBlanco">TODO EL PERSONAL ENVÍO SUS ASISTENCIAS!!</h3>
                        @endif
                    </div>
                @endif
        </div>
        
    </div>
    @endsection
    @section('script-footer')
    <script>
        llenarTablaPartes();
        function llenarTablaPartes(){            
            var partesMensuales = @json($ultimosPartes);
            partesMensuales.forEach(parte => {
                fechaParte  = parte.fecha_fin.split("-")
                document.getElementById("doc"+parte.id).href = "/parteMensual/docentes/"+{{$unidad->id}}+"/"+fechaParte[0]+"-"+fechaParte[1]+"-16";
                document.getElementById("aux"+parte.id).href = "/parteMensual/auxiliares/"+{{$unidad->id}}+"/"+fechaParte[0]+"-"+fechaParte[1]+"-16";

            });
        }
    </script>
@endsection
