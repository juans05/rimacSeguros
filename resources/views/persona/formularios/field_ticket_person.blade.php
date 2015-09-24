<div class="form-group">
    <input type="hidden" class="form-control" id="id" name="persona_cuenta" value="{{$persona->id}}" >
    <input type="hidden" class="form-control" id="id" name="ticket_padre" value="{{$ticketPadre2}}" >
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


