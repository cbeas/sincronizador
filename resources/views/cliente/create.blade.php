
@extends('layout.main')

@section('title') Cliente @endsection
 
@section('content')

    
<div class="container">
  <h2>Cliente</h2>
  <form action="{{action('web\ClienteController@store') }}" method="post">
  	
    @include('cliente.form') 

    <div class="checkbox">
      <label><input type="checkbox" name="encuesta"> Llenar Encuesta</label>
    </div>

 <button type="submit" class="btn btn-success text-center">Guardar</button>

 </form>

@endsection

