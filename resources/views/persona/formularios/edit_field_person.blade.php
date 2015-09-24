<div class="form-group">
    <input type="hidden" class="form-control" id="id" name="id_persona" value="{{$persona->id}}" >
    <label class="col-md-4 control-label">Nombre y apellido</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="nombre_persona" value="{{$persona->nombre_persona}}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">Tipo Documento</label>
    <div class="col-md-6">
        {!! Form::select('tipdoc',[''=>'Seleccionar Tipo','dni'=>'DNI','ruc'=>'RUC'],'dni',['class'=>'form-control'])!!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-4 control-label">Nro Documento</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="dni" value="{{$persona->dni}}" >
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">Nro Ticket</label>
    <div class="col-md-6">
        <select class="form-control" name="nomticket">
            @foreach($ticket as $tickets)
                <option value="{{$tickets->id}}">{{$tickets->nroticket}}</option>
            @endforeach
        </select>

    </div>
</div>
<div class="form-group">
    @for($i=0;$i<=(count($aplicativos2))-1;$i++)
        <div class="col-md-6">
            <label class="checkbox-inline">
                @if($aplicativos2[$i]['estado']=='true')
                    <input type="checkbox" id="inlineCheckbox1" checked="false" name="aplicativo[]" value="{{$aplicativos2[$i]['id_aplicativo']}}">{{$aplicativos2[$i]['nombre_aplicativo']}}
                @else
                    <input type="checkbox" id="inlineCheckbox1"  name="aplicativo[]" value="{{$aplicativos2[$i]['id_aplicativo']}}">{{$aplicativos2[$i]['nombre_aplicativo']}}
                @endif
            </label>
        </div>
    @endfor
</div>

</div>


