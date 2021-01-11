@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: <a
                                href="/facultades/{{ $facultad->id }}">{{ $facultad->nombre }}</a><</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>  
            <div class="container mt-4">
                <table class="table ">
                    
                @if (!$departamentos->isEmpty())
                        <tr>                            
                            <th class="textoBlanco border border-dark" scope="col">DEPARTAMENTO</th>
                            <th class="textoBlanco border border-dark" scope="col">ULTIMO PARTE MENSUAL</th>
                        </tr>
                        @forelse ($departamentos as $departamento)
                            <tr>
                                <td class="border border-dark"><a
                                    href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></td>
                                <td class="border border-dark"><strong>{{$departamento->mes}} </strong>
                                    <a id="doc{{$departamento->id}}" href="">Parte Docentes</a>
                                    <a id="aux{{$departamento->id}}" href="">Parte Auxiliares</a></td>
                                
                            </tr>
                        @empty            
                            <h3 class="textoBlanco">ESTA FACULTAD NO TIENE REGISTRADO NINGUN PARTE MENSUAL DE ALGUN DEPARTAMENTO</h3>
                        @endforelse
                    </table>
                    <div class="mt-3">
                        {{ $departamentos->links() }}
                    </div>
                    
                @else
                    <h3 class="textoBlanco">ESTA FACULTAD AUN NO TIENE REGISTRADO PARTES MENSUALES</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
     var depts=@json($departamentos).data;
     depts.forEach(dept => { 
        fechaParte  = dept.fecha_fin.split("-")
        document.getElementById("doc"+dept.id).href = "/parteMensual/docentes/"+dept.id+"/"+fechaParte[0]+"-"+fechaParte[1]+"-16";
        document.getElementById("aux"+dept.id).href = "/parteMensual/auxiliares/"+dept.id+"/"+fechaParte[0]+"-"+fechaParte[1]+"-16";
     });
 </script>
@endsection