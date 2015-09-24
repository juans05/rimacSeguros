@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lista de Usuario</div>

                    <div class="panel-body" ng-controller="MyCtrl">
                        {!! Form::open(['route' => 'busqueda-cuenta-lista_personas', 'method' => 'GET', 'class'=>'navbar-form navbar-left pull-right','role'=>'search']) !!}
                             <input type="hidden" class="form-control" id="id" name="pantalla" value="lista_personas" >
                            <div class="form-group">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre Usuario'])!!}
                            </div>
                            <select class="form-control" name="TipBusqu">
                                <option value="1">DNI</option>
                                <option value="2">Nombre</option>
                            </select>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        {!! Form::close() !!}
                        <p>
                            <a href="{{route('persona.create')}}" class="btn btn-info" role="button">Registrar Persona</a>
                        </p>


                        <table class="table table-hover"> <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Apellido y nombre</th>

                            </tr>

                            @for($i=0;$i<=(count($paginador))-1;$i++)
                                    <tr class="success">

                                        <td>{{$paginador[$i]->dni}}</td>
                                        <td>{{$paginador[$i]->nombre_persona}}</td>
                                        <td>
                                            <a href="{{route('add_vinculare_ticket-grabar',[($paginador[$i]->persona_id),($paginador[$i]->id)])}}">Vincular Nuevo Ticket</a>
                                            <a href=""></a>
                                        </td>
                                    </tr>
                            @endfor
                        </table>

                        <nav><ul class="pagination pagination-lg"> {!!$paginador->setPath('/personas/')!!}</ul></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
