@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrar Nuevos Aplicativos </div>


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
                                <a href="#" class="btn btn-primary" id="registrar" >Registrar</a>
                            </p>
                            <hr>

                                    <div class="form-group">
                                        <select class="form-control" id="areas" name="nomAplicativo">
                                            @foreach($area as $aplicativo2)
                                                <option value="{{$aplicativo2->id}}">{{$aplicativo2->nombre_area}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                        <hr>

                        <div class="modal"  id="form_aplicativo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                            <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">Registro de Aplicativo</h4>
                                            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <div class="form-group" id="combobox">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"  id="cerrarPupUPApli">Cerrar</button>
                                            <button type="button" class="btn btn-primary" id="guardarDatoss">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                             <div class="table-responsive">
                                 <!-- grilla de dinamica -->
                             </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    {!! Form::open(['route' => ['registrar-area-aplicativo',':AREA_ID',':APLICATIVO_ID'],'class'=>'navbar-form navbar-left pull-right','role'=>'search','id'=>'guardar_data','method'=>'post']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::close() !!}
    {!! Form::open(['route' => ['eliminar-area-aplicativo',':ID',':AREA_ID'],'class'=>'navbar-form navbar-left pull-right','role'=>'search','id'=>'eliminar_data','method'=>'post']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {!! Form::close() !!}
@endsection
@section('script')
    <script src="{{ asset('/js/app.js') }}"></script>
@endsection