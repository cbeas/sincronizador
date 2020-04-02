
@extends('layout.main')

@section('title') Flotilla @endsection
 
@section('content')

    
<div class="container">
  <h2>Flotilla </h2> 

<br>
  <span>{{$cliente->nombre}} {{$cliente->paterno}} {{$cliente->materno}}</span>
  
  <br><br>



  <div class="row">
    <div class="col">
      <a class="btn btn-success" href="{{action('web\FlotillaController@create',1) }}" role="button">Nueva Tarjeta</a>
      
    </div> 
  </div>  



<div class="mt-5">

  <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Tarjeta</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($tarjetas as $tarjeta)
    
    <tr>      
      <td>  <a href="{{action('web\FlotillaController@edit',$tarjeta->id_tarjeta) }}">{{ $tarjeta->nombre }}</a></td>
      <td>  {{ $tarjeta->tarjeta }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>



@endsection


