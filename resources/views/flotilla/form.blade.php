    {{ csrf_field() }}
    <input type="hidden" id="id_cliente" name="id_cliente"  value="{{$cliente->id_cliente}}"/>
    
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
      value="{{old('nombre',isset($tarjeta->nombre)?$tarjeta->nombre:null)}} ">      
    </div>
    <div class="form-group col-md-6">
      <label for="tarjeta">Tarjeta</label>
      <input type="text" class="form-control" id="tarjeta" name="tarjeta" placeholder="Tarjeta"
      value="{{old('tarjeta',isset($tarjeta->tarjeta)?$tarjeta->tarjeta:null)}} "
      {{isset($tarjeta->tarjeta)? 'disabled' : ''}}>
      
    </div>

  </div>

    
  <div class="form-row">    
    <button type="submit" class="btn btn-success  text-center">Guardar</button>
  </div>