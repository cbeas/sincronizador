
@extends('layout.main')

@section('title') Cliente @endsection
 
@section('content')

    
<div class="container">
  <h2>Cliente</h2>
  <form action="{{action('web\ClienteController@update', $cliente->id_cliente) }}" method="post">
  	{{ method_field('PATCH') }}
    @include('cliente.form') 


 <button type="submit" class="btn btn-success text-center">Guardar</button>

 </form>

@endsection

