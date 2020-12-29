@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3> 
                <br> 
                <h3 class="textoBlanco"> {{strtoupper($mes)}}  </h3>  
                
            <div class="container mt-4">
                <table class="table ">
                    
                @if (!$departamentos->isEmpty())
                        <tr>                            
                            <th class="textoBlanco border border-dark" scope="col">DEPARTAMENTO</th>
                            <th class="textoBlanco border border-dark" scope="col">PARTES MENSUALES</th>
                            <th class="textoBlanco border border-dark" scope="col">ESTADO</th>
                            <th class="textoBlanco border border-dark" scope="col">APROBAR</th>
                        </tr>
                        @foreach ($departamentos as $departamento)
                            <tr class="">
                                <td class="border border-dark align-middle"><a
                                    href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></td>
                                    @if ($departamento->parteID!=null)
                                        <td class="border border-dark align-middle ">
                                            <a href="/parteMensual/auxiliares/{{ $departamento->id}}/{{$departamento->fecha_ini}}">Ver parte auxiliares</a>
                                            <a href="/parteMensual/docentes/{{ $departamento->id}}/{{$departamento->fecha_ini}}">Ver parte docentes</a>                                        
                                        </td>
                                        <td class="border border-dark ">
                                            <p>Encargado facultativo: @if($departamento->encargado_fac)SI @else NO @endif</p>
                                            <p>Director academico: @if($departamento->dir_academico)SI @else NO @endif</p>
                                            <p>Decano: @if($departamento->decano)SI @else NO @endif</p>
                                            <p>Jefe de departamento: @if($departamento->jefe_dept)SI @else NO @endif</p>
                                        </td>
                                        <td class="border border-dark ">
                                            @esJefeDepartamento($departamento->id) 
                                                @if ($departamento->encargado_fac)
                                                    APROBADOS                                                    
                                                @else
                                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                                    class="form-inline my-2 my-lg-0 d-inline"
                                                >
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name = 'parte_id' value = '{{$departamento->parteID}}'>
                                                    <input type="hidden" name = 'rol' value ='4'>
                                                </form>
                                                    <input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR">
                                                @endif
                                            @else 
                                                POR APROBAR
                                            @endesEncargadoFac
                                            @esEncargadoFac($facultad->id) 
                                                @if ($departamento->encargado_fac)
                                                    APROBADOS                                                    
                                                @else
                                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                                    class="form-inline my-2 my-lg-0 d-inline"
                                                >
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name = 'parte_id' value = '{{$departamento->parteID}}'>
                                                    <input type="hidden" name = 'rol' value ='5'>
                                                </form>
                                                    <input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR">
                                                @endif
                                            @else 
                                                POR APROBAR
                                            @endesEncargadoFac
                                            @esDecano($facultad->id) 
                                                @if ($departamento->encargado_fac)
                                                    APROBADOS                                                    
                                                @else
                                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                                    class="form-inline my-2 my-lg-0 d-inline"
                                                >
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name = 'parte_id' value = '{{$departamento->parteID}}'>
                                                    <input type="hidden" name = 'rol' value ='6'>
                                                </form>
                                                    <input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR">
                                                @endif
                                            @else 
                                                POR APROBAR
                                            @endesDecano
                                            @esDirAcademico($facultad->id) 
                                                @if ($departamento->encargado_fac)
                                                    APROBADOS                                                    
                                                @else
                                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                                    class="form-inline my-2 my-lg-0 d-inline"
                                                >
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name = 'parte_id' value = '{{$departamento->parteID}}'>
                                                    <input type="hidden" name = 'rol' value ='7'>
                                                </form>
                                                    <input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR">
                                                @endif
                                            @else 
                                                POR APROBAR
                                            @endesDirAcademico
                                            
                                        </td>
                                    @else
                                        <td class="border border-dark ">NO HAY PARTES MENSUALES DISPONIBLES </td>
                                        <td class="border border-dark "> - </td>
                                        <td class="border border-dark "> - </td>                                        
                                    @endif
                                    </td>
                                
                            </tr>
                        @endforeach
                    </table>
                @esEncargadoFac($facultad->id)
                    @if (!$departamentos[0]->aprobado)
                        <button class="boton btn btn-success textoNegro" onclick="enviarDPA({{$departamentos}})">ENVIAR A DPA</button>
                        {{-- <button class="boton btn btn-success textoNegro">SOLICITAR APROBACION</button>  --}}
                        <form action="{{route('enviarPartesDPA')}}" method="post" id="enviarDPA">
                            @csrf @method('PATCH')
                            <input type="hidden" name="facultad_id" value="{{$facultad->id}}">
                            <input type="hidden" name="fechaIni" value="{{$departamentos[0]->fecha_ini}}">
                        </form>
                    @endif                        
                @endesEncargadoFac
                @else
                    <h3 class="textoBlanco">ESTA FACULTAD AUN NO TIENE REGISTRADO PARTES MENSUALES</h3>
                @endif

{{$departamentos}}
            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
     function deptsSinPartesMensuales(departamentos){
         res = "";
         departamentos.forEach(departamento => {
             if(departamento.parteID == null){
                res = res + " " +departamento.nombre+",";
             }
         });
        return res.substring(0, res.length - 1);
     }
     function partesMensualesNoAprobados(departamentos){
        res = "";
         departamentos.forEach(departamento => {
             if(!(departamento.jefe_dept && departamento.dir_academico && departamento.encargado_fac && departamento.decano)){
                res = res + " " +departamento.nombre+",";
             }
         });
        return res.substring(0, res.length - 1);
     }
     function enviarDPA(departamentos){
        deptsSinPartes = deptsSinPartesMensuales(departamentos);
        partesSinAprobar = partesMensualesNoAprobados(departamentos);
        if(deptsSinPartes.length == 0 && partesSinAprobar.length==0 ){
            var agree = confirm("¿Estás seguro de enviar todos los partes mensuales a DPA?, no habrá marcha atrás.",
            function() {
                alertify.success('Aceptar');
            },
            function() {
                alertify.error('Cancelar');
            });
            if(agree){
                document.getElementById('enviarDPA').submit();
            }
        }else if(deptsSinPartes.length > 0){
            alert("No se pueden enviar los partes mensuales. Los siguientes departamentos aun no han enviado sus asistencias para generar los partes mensuales:"+ deptsSinPartes+'.');
        }else if(partesSinAprobar.length > 0 ){
            var agree = confirm("Algunos encargados de revisar los partes aun no han aprobado sus partes mensuales:"+partesSinAprobar+". ¿Estás seguro de enviar todos los partes mensuales a DPA?, no habrá marcha atrás.",
            function() {
                alertify.success('Aceptar');
            },
            function() {
                alertify.error('Cancelar');
            });
            if(agree){
                document.getElementById('enviarDPA').submit();
            }
        }
     }
 </script>
@endsection
