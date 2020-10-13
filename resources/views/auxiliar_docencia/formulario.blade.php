@foreach ($departamentos as $d)
    <h1>{{ $d['title'] }}</h1>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Grupo</th>
            <th>Materia</th>
            <th>Contenido de Clase</th>
            <th>Indicador Verificable</th>
            <th>Observaciones</th>
            <th>Permiso</th>
        </tr>

        @foreach ($materias as $m)
            @if ($d['title'] == $m['departamento'])
            
              <tr>
                    <td>Aqui va la fecha</td>
                    <td>{{ $m['horario'] }}</td>
                    <td>{{ $m['grupo'] }}</td>
                    <td>{{ $m['materia'] }}</td>
                    <td>
                      <textarea name="contenido" id="auxDocForm" cols="30" rows="10" placeholder="Contenido de la clase"></textarea>
                    </td>
                    <td>
                      <textarea name="indicador" id="auxDocForm" cols="30" rows="10" placeholder="Indicador verificable"></textarea>
                    </td>
                    <td>
                      <textarea name="observaciones" id="auxDocForm" cols="30" rows="10" placeholder="Observaciones"></textarea>
                    </td>
                    
                    <td>Aqui va el permiso</td>
              </tr>

            @endif
        @endforeach

    </table>

@endforeach