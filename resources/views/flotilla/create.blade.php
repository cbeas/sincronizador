
@extends('layout.main')

@section('title') Flotilla @endsection
 
@section('content')

    
<div class="container">
  <h2>Flotilla</h2>  <span>{{$cliente->nombre}} {{$cliente->paterno}} {{$cliente->materno}}</span>
  <form action="{{action('web\FlotillaController@store') }}" method="post">    
    @include('flotilla.form') 

 </form>

@endsection



    

