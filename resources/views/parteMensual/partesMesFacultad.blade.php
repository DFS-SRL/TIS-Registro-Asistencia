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
                            <th class="textoBlanco border border-dark" scope="col">ULTIMO PARTE MENSUAL</th>
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
                                            @esEncargadoFac($facultad->id) 
                                                @if ($departamento->encargado_fac)
                                                    APROBADOS                                                    
                                                @else
                                                <form method="POST" action="{{ route('aprobarParteRol') }}" id='aprobarParteRol'
                                                    class="form-inline my-2 my-lg-0 d-inline"
                                                >
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name = 'parte_id' value = '{{$departamento->parteID}}'>
                                                </form>
                                                    <input onclick="document.getElementById('aprobarParteRol').submit();" class="boton btn textoNegro" type="button" value="APROBAR PARTES">
                                                @endif
                                            @else 
                                                POR APROBAR
                                            @endesEncargadoFac
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
                    <button class="boton btn btn-success textoNegro" onclick="document.getElementById('enviarDPA').submit();">ENVIAR A DPA</button>
                    {{-- <button class="boton btn btn-success textoNegro">SOLICITAR APROBACION</button>  --}}
                    <form action="{{route('enviarPartesDPA')}}" method="post" id="enviarDPA">
                        @csrf @method('PATCH')
                        <input type="hidden" name="facultad_id" value="{{$facultad->id}}">
                        <input type="hidden" name="fechaIni" value="{{$departamentos[0]->fecha_ini}}">
                    </form>
                @endesEncargadoFac
                @else
                    <h3 class="textoBlanco">ESTA FACULTAD AUN NO TIENE REGISTRADO PARTES MENSUALES</h3>
                @endif


            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
 </script>
@endsection
