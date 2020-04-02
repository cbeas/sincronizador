
@extends('layout.main')

@section('title') Flotilla @endsection
 
@section('content')

    
<div class="container">
  <h2>Flotilla</h2>  <span>{{$cliente->nombre}} {{$cliente->paterno}} {{$cliente->materno}}</span>
  <form action="{{action('web\FlotillaController@update', $cliente->id_cliente) }}" method="post">
    {{ method_field('PATCH') }}
    @include('flotilla.form') 

 </form>

@endsection



    

