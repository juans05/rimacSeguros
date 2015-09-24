@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registros excel Fuerza de Venta</div>
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
                            {!! Form::open(['route' => 'cargar-data-excel', 'method' => 'POST','files'=>'true', 'class'=>'form-horizontal']) !!}
                            <div class="form-group">
                                <label class="col-md-2 control-label">Cargar Data</label>
                                <div class="col-md-6">
                                    {!! Form::file('excel') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Nro Ticket</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="nro_ticket" name="nro_ticket" placeholder="">
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    Cargar Data
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Salir
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                    @if ($mensaje!="")
                        <div class="alert alert-info">
                            <strong>  {{$mensaje}}!</strong><br><br>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    </div>
@endsection
