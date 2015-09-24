@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ticket Relacionados a {{$persona->nombre_persona}} </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Error!</strong> Hay algunos incovenientes con los siguentes campos.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <p>
                                <a href="{{ URL::previous() }}" class="btn btn-info" role="button">Regresar</a>

                            </p>
                            <table class="table table-hover"> <thead>
                                <tr>
                                    <th>Nro Ticket</th>
                                    <th>Fecha de Registro</th>
                                    <th>Estado</th>

                                </tr>

                                @for($i=0;$i<=(count($ticket))-1;$i++)
                                    <tr class="info" data-id="{{$ticket[$i]->id_ticket}}">
                                        <td>{{$ticket[$i]->nroticket}}</td>
                                        <td>{{$ticket[$i]->created_at}}</td>
                                        <td>
                                            @if($ticket[$i]->estado_persona_ticket==0)
                                                No Completado
                                            @elseif($ticket[$i]->estado_persona_ticket==1)
                                                completado
                                            @else
                                                Enviado
                                            @endif
                                        </td>
                                        <td>
                                            {{$ticket[$i]->id_ticket}}
                                        </td>
                                        <td >

                                            <a href="{{route('ver-cuenta-usu',$ticket[$i]->id_ticket)}}">ver aplicativo</a>

                                            <a href="">||</a>
                                            <a class="btn-eliminar" href="">Eliminar</a>
                                            <a href=""></a>
                                        </td>
                                    </tr>

                                @endfor
                            </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => ['eliminar-persona',':USER_ID'],'class'=>'navbar-form navbar-left pull-right','role'=>'search','id'=>'eliminar_data','method'=>'post']) !!}
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ asset('/js/app.js') }}"></script>
@endsection