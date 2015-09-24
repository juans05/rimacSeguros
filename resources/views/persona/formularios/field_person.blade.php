<div class="form-group">

    <label class="col-md-4 control-label">Nombre y apellido</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="nombre_persona" value="{{ old('nombre_persona') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">Tipo Documento</label>
    <div class="col-md-6">
        {!! Form::select('tipdoc',[''=>'Seleccionar Tipo','dni'=>'DNI','ruc'=>'RUC'],null,['class'=>'form-control'])!!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-4 control-label">Nro Documento</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="dni" value="{{ old('dni') }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-4 control-label">Email</label>
    <div class="col-md-6">
        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-4 control-label">Nro Ticket</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="ticket" value="{{ old('ticket') }}">
    </div>
</div>
<div class="form-group">

    @foreach($aplicativo as $aplic)

    <div class="col-md-6">
        <label class="checkbox-inline">
            <input type="checkbox" id="inlineCheckbox1" name="aplicativo[]" value="{{$aplic->id}}">{{$aplic->nombre_aplicativo}}
        </label>
    </div>

        @endforeach
</div>


