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
                            <p>
                                <a href="{{ Redirect::back() }}" class="btn btn-info" role="button">Regresar</a>
                            </p>
                            <hr>
                            {!! Form::open(['route' => 'registrar-aplicativoticket', 'method' => 'POST', 'class'=>'form-inline']) !!}
                                    <div class="form-group">
                                        <label for="exampleInputName2">Aplicativo</label>
                                        <input type="hidden" class="form-control" id="id" name="persona_cuenta" value="{{$persona->id}}" >
                                        <input type="hidden" class="form-control" id="id" name="persona_ticket" value="{{$persona_ticket->id}}" >

                                        <select class="form-control" name="nomAplicativo">
                                            @foreach($aplicativo as $aplicativo2)
                                                <option value="{{$aplicativo2->id}}">{{$aplicativo2->nombre_aplicativo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" class="btnRegistrar">Registrar cuenta</button>
                            {!! Form::close() !!}
                        <hr>
                        <div class="form-group">
                             <div class="table-responsive">
                                <table class="table table-condensed ">
                                    <thead>
                                    <tr>
                                        <th>Nombre Aplicativo</th>
                                        <th>Usuario Creador</th>
                                        <th>Fecha Creacion</th>
                                    </tr>
                                    </thead>
                                    @foreach($data as $cuenta)
                                        <tr class="success" data-id_ticket="{{$persona_ticket->id}}" data-id_aplicativo="{{$cuenta->id}}">

                                            <td>{{$cuenta->nombre_aplicativo}}</td>
                                            <td>{{$cuenta->usucrea}}</td>
                                            <td>{{$cuenta->created_at}}</td>
                                            <td>
                                                <a class="btn-eliminar_aplicativo" href="">Eliminar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                             </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    {!! Form::open(['route' => ['eliminar-persona-aplicativo',':TICKET_ID',':APLICATIVO_ID'],'class'=>'navbar-form navbar-left pull-right','role'=>'search','id'=>'eliminar_data','method'=>'post']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::close() !!}
@endsection
@section('script')
    <script src="{{ asset('/js/app.js') }}"></script>
@endsection