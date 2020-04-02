
@extends('layout.main')

@section('title') Buscar Cliente @endsection
 
@section('content')

    
<div class="container">
  <h2>Buscar Cliente</h2>
  <form action="{{action('web\ClienteController@search') }}" method="post">
    {{ csrf_field() }}
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="q">Buscar</label>
      <input type="input" class="form-control" id="q" name="q" placeholder="Cliente / Tarjeta"
      value="{{old('q',isset($request['q'])? $request['q'] : null)}} ">      
    </div>
    <div class="form-group col-md-4">
      <label for="estatus">Estatus de Cliente:</label>
      <select class="form-control" id="estatus" name="estatus" >
        @include('layout.selectGenerico',['select' => $estatusCliente,'old'=>old('estatus',isset($request['estatus'])? $request['estatus']: null)]) 
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="adicional">Adicionales:</label>
      <select class="form-control" id="adicional" name="adicional" >
        @include('layout.selectGenerico',['select' => $adicional,'old'=>old('adicional',isset($request['adicional'])? $request['adicional']: null)])  
      </select>
    </div>
  </div>

    
  <div class="form-row">    
    <button type="submit" class="btn btn-primary text-center">Buscar</button>
  </div>
 </form>


<div class="mt-5">

  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Tarjeta</th>
      <th scope="col">Saldo</th>
      <th scope="col">Estatus</th>
      <th scope="col">Adicional</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($clientes as $cliente)
    
    <tr>      
      <td> 
        <a href="{{action('web\ClienteController@edit',$cliente->id_cliente) }}"> {{ $cliente->nombre }} {{ $cliente->paterno }} {{ $cliente->materno }}</a>
       </td>
      <td>  {{ $cliente->tarjeta }}</td>
      <td>  {{ $cliente->saldo }}</td>
      <td>   @include('layout.getInList',['values' => $tblEstatus,'valor'=>$cliente->estatus])</td>
      <td>   @include('layout.getInList',['values' => $tblAdicional,'valor'=>$cliente->adicional])</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

{{ $clientes->links() }}

@endsection


