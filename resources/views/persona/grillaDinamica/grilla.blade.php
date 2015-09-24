<table class="table table-hover ">
    <thead>
    <tr>
        <th>Nombre Aplicativo</th>
    </tr>
    </thead>
    @foreach($datos as $cuenta)
        <tr class="success" data-id="{{$cuenta->id}}">

            <td>{{$cuenta->nombre_aplicativo}}</td>

            <td>
                <a class="btn-eliminar" href="">Eliminar</a>
            </td>
        </tr>
    @endforeach
</table>

