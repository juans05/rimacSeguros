@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registro</div>
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
                            {!! Form::open(['route' => 'persona.store', 'method' => 'POST', 'class'=>'form-horizontal']) !!}

                                @include('persona.formularios.field_person')
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Salir
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                    </div>


                </div>
            </div>
        </div>
    </div>


    </div>
@endsection
