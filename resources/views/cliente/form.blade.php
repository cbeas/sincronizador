 {{ csrf_field() }}
  <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="nombre" class="form-control" id="nombre" placeholder="Ingresa nombre" name="nombre" value="{{old('nombre',isset($cliente->nombre)? $cliente->nombre : null)}}">  

   </div>
   <span id="datos_perfis">
	   <div class="form-group">
	      <label for="paterno">Apellido Paterno:</label>
	      <input type="paterno" class="form-control" id="paterno" placeholder="Ingresa Apellido Paterno" name="paterno"  
        value="{{old('paterno',isset($cliente->paterno)? $cliente->paterno : null)}}">
	   </div>
	   <div class="form-group">
	      <label for="materno">Apellido Materno:</label>
	      <input type="materno" class="form-control" id="materno" placeholder="Ingresa Apellido Materno" name="materno" 
        value="{{old('materno',isset($cliente->materno)? $cliente->materno : null)}}">
	   </div>
	</span>   
  <div class="form-group">
    <label for="sexo">Sexo:</label>
    <select class="form-control" id="sexo" name="sexo" >
      @include('layout.selectGenerico',['select' => $sexo,'old'=>old('sexo',isset($cliente->sexo)? $cliente->sexo : null)])  
    </select>
  </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" 
      value="{{old('email',isset($cliente->correo)? $cliente->correo : null)}}">
    </div>
   <div class="form-group">
      <label for="celular">Celular:</label>
      <input type="celular" class="form-control" id="nombre" placeholder="Ingresa Celular" name="celular" 
      value="{{old('celular',isset($cliente->celular)? $cliente->celular : null)}}">
   </div>

   <div class="form-group">
  	<label for="estatus">Estatus de Cliente:</label>
    <select class="form-control" id="estatus" name="estatus" >
      @include('layout.selectGenerico',['select' => $estatusCliente,'old'=>old('estatus',isset($cliente->estatus)? $cliente->estatus : null)]) 
    </select>
	</div>

    <div class="form-group">
      <label for="tarjeta">Tarjeta:</label>
      <input type="tarjeta" class="form-control" id="tarjeta" placeholder="Ingresa Tarjeta" name="tarjeta" 
      value="{{old('tarjeta',isset($tarjeta->tarjeta)? $tarjeta->tarjeta : null)}}"
      {{isset($tarjeta->tarjeta)? 'disabled' : ''}}>
      
    </div>

   <div class="form-group">
  	<label for="flotilla">Flotilla:</label>
    <select class="form-control" id="flotilla" name="flotilla" >
      @include('layout.selectGenerico',['select' => $flotilla,'old'=>old('flotilla',isset($cliente->flotilla)? $cliente->flotilla : null)]) 
    </select>
	</div>



<div class="form-group">
  	<label for="membresia">Membresía:</label>
    <select class="form-control" id="membresia" name="membresia" >
            @foreach($membresias as $membresia)
              <option value="{{$membresia->id_membresia}}"
              @if ($membresia->id_membresia== old('membresia',isset($cliente->id_memebresia)? $cliente->id_memebresia : null))
                selected
              @endif

              >{{$membresia->membresia}}                
              </option>
          @endforeach
    </select>
	</div>
<div class="form-group">
  	<label for="ubicacion">Ubicación:</label>
    <select class="form-control" id="ubicacion" name="ubicacion" >
          @foreach($ubicaciones as $ubicacion)
              <option value="{{$ubicacion->id_ubicacion}}"
              @if ($ubicacion->id_ubicacion== old('ubicacion',
              isset($cliente->id_ubicacion_inicial)? $cliente->id_ubicacion_inicial : null))
                selected
              @endif

              >{{$ubicacion->ubicacion}}                
              </option>
          @endforeach
        
    </select>
	</div>



