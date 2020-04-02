@if(isset($values) && count($values)>0 && isset($valor))
        @foreach ($values as $k=>$val)
            @if($valor==$k)
              {{$val}}
            @endif

          @endforeach
@endif