<label for="recipient-name" class="control-label">Aplicativo a Registrar </label>
<select class="form-control" id="aplicativo" name="nomAplicativo">
    @foreach($datos as $aplicativo2)
        <option value="{{$aplicativo2->id}}">{{$aplicativo2->nombre_aplicativo}}</option>
    @endforeach
</select>