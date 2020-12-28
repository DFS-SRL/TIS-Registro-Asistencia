@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
    <link rel="stylesheet" href="/css/informacion/personalAcademico.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>  
            <div class="container mt-4">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item tab-item">
                        <a class="nav-link active" id="departamentos-tab" data-toggle="tab" href="#departamentos" role="tab" aria-controls="departamentos"
                            aria-selected="true" onclick="departamentos()">DEPARTAMENTOS</a>
                    </li>
                    <li class="nav-item tab-item">
                        <a class="nav-link" id="mesesPartes-tab" data-toggle="tab" href="#mesesPartes" role="tab" aria-controls="mesesPartes"
                            aria-selected="false" onclick="mesesPartes()">PARTES MENSUALES</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <table class="table table-bordered table-responsive">
                        <div class="tab-pane fade show active" id="departamentos" role="tabpanel" aria-labelledby="departamentos-tab">
                            <div id="departamentos-content">
                                <ul class="list-group">
                                    @forelse ($departamentos as $departamento)
                                        <li class="list-group-item linkMateria lista"><a
                                                href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></li>
                                    @empty
                                        <h3>ESTA FACULTAD NO TIENE REGISTRADO NINGUN DEPARTAMENTO</h3>
                                    @endforelse
                                </ul>
                            </div>
                            {{ $departamentos->links() }}
                        </div>
                        <div class="tab-pane fade" id="mesesPartes" role="tabpanel" aria-labelledby="mesesPartes-tab">
                            <div id="mesesPartes-content">
                                <ul class="list-group">
                                    @forelse ($mesesPartes as $mesPartes)
                                        <li class="list-group-item linkMateria lista"><a
                                                href="/facultades/{{$facultad->id}}/{{ $mesPartes->año }}-{{ $mesPartes->mes }}">{{ $mesPartes->mes }} - {{ $mesPartes->año }}</a></li>
                                    @empty
                                        <h5>NO EXISTEN PARTES MENSUALES REGISTRADOS</h5>
                                    @endforelse
                                </ul>
                            </div>
                            {{ $departamentos->links() }}
                        </div>
                        
                    </table>
                </div>
                {{-- <table class="table ">                    
                @if (!$departamentos->isEmpty())
                        <tr>                            
                            <th class="textoBlanco border border-dark" scope="col">DEPARTAMENTO</th>
                            <th class="textoBlanco border border-dark" scope="col">ULTIMO PARTE MENSUAL</th>
                            <th class="textoBlanco border border-dark" scope="col">APROBADO</th>
                        </tr>
                        @foreach ($departamentos as $departamento)
                            <tr class="">
                                <td class="border border-dark align-middle"><a
                                    href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></td>
                                <td class="border border-dark align-middle"><strong>{{$departamento->mes}} </strong> 
                                                                            <a href="" id="doc{{$departamento->id}}">Ver parte docentes</a>
                                                                            <a href="" id="aux{{$departamento->id}}" >Ver parte auxiliares</a></td>
                                <td class="border border-dark ">
                                    <label for="{{$departamento->id}}encargadoFac">Encargado facultativo</label>
                                    <input id="{{$departamento->id}}encargadoFac"type="checkbox" disabled><br>
                                    <label for="{{$departamento->id}}dirAcademico">Director academico</label>
                                    <input id="{{$departamento->id}}dirAcademico"type="checkbox" disabled><br>
                                    <label for="{{$departamento->id}}decano">Decano</label>
                                    <input id="{{$departamento->id}}decano"type="checkbox" disabled><br>
                                    <label for="{{$departamento->id}}jefeDept">Jefe de departamento</label>
                                    <input id="{{$departamento->id}}jefeDept"type="checkbox" disabled>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mt-3">
                        {{ $departamentos->links() }}
                    </div>
                @else
                    <h3 class="textoBlanco">ESTA FACULTAD AUN NO TIENE REGISTRADO PARTES MENSUALES</h3>
                @endif --}}


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
        document.getElementById(dept.id+'encargadoFac').checked = dept.encargado_fac;
        document.getElementById(dept.id+'dirAcademico').checked = dept.dir_academico;
        document.getElementById(dept.id+'decano').checked = dept.decano;
        document.getElementById(dept.id+'jefeDept').checked = dept.jefe_dept;
     });
 </script>
@endsection
