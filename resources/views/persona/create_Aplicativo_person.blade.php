@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrar Nuevos Aplicativos para : <b>{{$persona->nombre_persona}}</b></div>


                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Hubo algunos problemas con los Datos.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            @if ($mensaje!="")
                                <div class="alert alert-info">
                                       {{$mensaje}}
                                </div>
                            @endif
                        @if(count($data)>count($personaxAplicativo))
                            <hr>
                            {!! Form::open(['route' => 'cuenta-grabar2', 'method' => 'POST', 'class'=>'form-inline']) !!}
                                    <div class="form-group">
                                        <label for="exampleInputName2">Aplicativo</label>
                                        <input type="hidden" class="form-control" id="id" name="persona_cuenta" value="{{$persona->id}}" >

                                        <select class="form-control" name="nomAplicativo">
                                            @foreach($data as $aplicativo)
                                                <option value="{{$aplicativo->id}}">{{$aplicativo->nombre_aplicativo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">Usuario</label>
                                        <input type="text" class="form-control" id="nombre_cuenta" name="nombre_cuenta" placeholder="Nombre Usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Clave</label>
                                        <input type="password" class="form-control" id="clave"  name="clave"  placeholder="clave">
                                    </div>
                                @if(count($numeroTicket)>=1)
                                    <div class="form-group">
                                        <label for="exampleInputName2">Ticket</label>s
                                        <select class="form-control" name="nomticket">
                                            @foreach($numeroTicket as $ticket)
                                                <option value="{{$ticket->nroticket}}">{{$ticket->nroticket}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                    <button type="submit" class="btn btn-primary">Registrar cuenta</button>
                            {!! Form::close() !!}
                         @endif
<hr>
                        <div class="form-group">
                             <div class="table-responsive">
                                <table class="table table-condensed ">
                                    <thead>
                                    <tr>
                                        <th>Nro Ticket</th>
                                        <th>Nombre Aplicativo</th>
                                        <th>Cuenta</th>
                                        <th>Usuario Creador</th>
                                        <th>Estado</th>
                                        <th>Fecha Creacion</th>

                                    </tr>
                                    </thead>
                                    @foreach($personaxAplicativo as $cuenta)
                                        <tr class="success" data-id="{{$cuenta->id}}">
                                            <td>{{$cuenta->ticket}}</td>
                                            <td>{{$cuenta->nombre_aplicativo}}</td>
                                            <td>{{$cuenta->cuenta_usu}}</td>
                                            <td>{{$cuenta->usucrea}}</td>
                                            <td>
                                                @if($cuenta->estado==1)
                                                    Registrado
                                                @elseif($cuenta->estado==2)
                                                    Entregado
                                                @else
                                                    Terminado
                                                @endif
                                            </td>
                                            <td>{{$cuenta->created_at}}</td>
                                            <td>
                                                <a href="{{route('cuenta-eliminar',[$cuenta->id,$cuenta->ticket])}}">ELIMINAR</a>
                                            </td>
                                            <td>
                                                <a class="btn-cambiarEstado" href="{{route('cuenta-cambiar',[$cuenta->id])}}">ENTREGAR</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                             </div>
                        </div>
                            @if(count($data)<=count($personaxAplicativo))

                            <div class="form-group ">
                                <div class="col-md-6 col-md-offset-2">
                                    {!! Form::open(['route' => 'cuenta-exportar', 'method' => 'POST', 'class'=>'form-inline']) !!}
                                    <input type="hidden" class="form-control" id="id2" name="persona_cuenta2" value="{{$persona->id}}" >
                                    <button type="submit" class="btn btn-primary">
                                        exportar
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
