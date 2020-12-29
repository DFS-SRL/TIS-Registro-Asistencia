@extends('layouts.master')

@section('title', 'Informacion Dept')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h3>
                <h3 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h3>
                <h3 class="textoBlanco">JEFE DE DEPARTAMENTO: {{$unidad->jefe->nombre}}  </h3>                
                <br>
                <strong class="textoBlanco">INFORMACION DEL DEPARTAMENTO</strong><br><br>
                <div class="d-flex justify-content-around"> 
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/materias/{{$unidad->id}}'">MATERIAS</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/cargos/{{$unidad->id}}'">CARGOS DE LABORATORIO</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/personalAcademico/{{$unidad->id}}'" >PERSONAL ACADEMICO</button>
                    @if(App\User::tieneAlMenosUnRol([4,5,6,7,8]))
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/personalAcademico/registrar/{{$unidad->id}}'" >REGISTRAR PERSONAL ACADEMICO</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/partes/mensuales/{{$unidad->id}}'">BUSCAR PARTE MENSUAL</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/informes/{{$unidad->id}}'">INFORMES SEMANALES</button>
                    @endif
                    
                </div>
                @if ($unidad->jefe->codSis == auth()->user()->usuario_codSis)
                    @if (!$ultimosPartes->isEmpty())
                    <br><strong class="textoBlanco">ULTIMOS PARTES MENSUALES</strong><br>
                    <div >
                        <table class = "table " id="ultimosPartes">
                            @foreach ($ultimosPartes as $values => $parte)
                            <tr>
                                <td class="border border-dark"><strong >{{$parte->mes}}</strong></td>
                                <td class="border border-dark"><a href="/" id="doc{{$parte->id}}">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="/" id="aux{{$parte->id}}">Ver parte auxiliares</a></td>
                                @aproboParte($parte->id)
                                <td class="border border-dark"><input class="boton btn textoNegro" type="button" value="APROBAR PARTES" disabled></td>    
                                @else
                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                class="form-inline my-2 my-lg-0 d-inline"
                                >
                                @csrf @method('PATCH')
                                <input type="hidden" name = 'parte_id' value = '{{$parte->id}}'>
                            </form>
                            <td class="border border-dark"><input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR PARTES"></td>
                            @endif
                        </tr>
                        @endforeach
                    </table>       
                </div>
                @else
                <h3 class="textoBlanco">A&UacuteN NO HAY PARTES MENSUALES DISPONIBLES</h3>
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
