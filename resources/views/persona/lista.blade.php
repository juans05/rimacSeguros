@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lista de Usuario</div>

                    <div class="panel-body">
                        {!! Form::open(['route' => 'busqueda-cuenta', 'method' => 'GET', 'class'=>'navbar-form navbar-left pull-right','role'=>'search']) !!}
                        <input type="hidden" class="form-control" id="id" name="pantalla" value="lista" >
						     <select class="form-control" name="TipBusqu">
                                <option value="1">DNI</option>
                                <option value="2">Nombre</option>
                            </select>
                            <div class="form-group">
                           {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre Usuario'])!!}
                            </div>
                           
                            <button type="submit" class="btn btn-default">Buscar</button>
                        {!! Form::close() !!}
                        <p>
                            <a href="{{route('persona.create')}}" class="btn btn-info" role="button">Registrar Persona</a>
                            <a href="{{route('listar-personas')}}" class="btn btn-info" role="button">Agregar Ticket</a>
                        </p>


                        <table class="table table-hover"> <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Apellido y nombre</th>
                                <th>Estado Persona</th>
                            </tr>

                            @for($i=0;$i<=(count($paginador))-1;$i++)
                                @if($paginador[$i]->estado==0)
                                    <tr class="success">
                                        <td>{{$paginador[$i]->dni}}</td>
                                        <td>{{$paginador[$i]->nombre_persona}}</td>

                                        <td>
                                            @if($paginador[$i]->estado==0)
                                                No Completado
                                            @elseif($paginador[$i]->estado==1)
                                                completado
                                            @else
                                                Enviado
                                            @endif
                                        </td>

                                        <td>
                                          
                                            <a href="{{route('add_cuenta-grabar',$paginador[$i]->persona_id)}}">AGREGAR</a>
                                            <a href="">||</a>
                                            <a href="{{route('modificar-cuenta',$paginador[$i]->persona_id)}}">MODIFICAR</a>
                                            <a href=""></a>



                                        </td>
                                    </tr>
                                @elseif($paginador[$i]->estado==1)
                                    <tr class="active">

                                        <td>{{$paginador[$i]->dni}}</td>
                                        <td>{{$paginador[$i]->nombre_persona}}</td>

                                        <td>
                                            @if($paginador[$i]->estado==0)
                                                No Completado
                                            @elseif($paginador[$i]->estado==1)
                                                completado
                                            @else
                                                Enviado
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{route('add_cuenta-grabar',$paginador[$i]->persona_id)}}">VER</a>
                                            <a href="">||</a>
                                            <a href="{{route('add_cerrar_cuenta-grabar',$paginador[$i]->persona_id)}}">CERRAR</a>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="info">
                                        <td>{{$paginador[$i]->dni}}</td>
                                        <td>{{$paginador[$i]->nombre_persona}}</td>
                                        <td>
                                            @if($paginador[$i]->estado==0)
                                                No Completado
                                            @elseif($paginador[$i]->estado==1)
                                                completado
                                            @else
                                                Enviado
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{route('ver-cuenta-usu',$paginador[$i]->persona_id)}}">VER</a>

                                        </td>
                                    </tr>
                            @endif
                            @endfor


                        </table>

                        <nav><ul class="pagination pagination-lg"> {!!$paginador->setPath('/home/')!!}</ul></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
