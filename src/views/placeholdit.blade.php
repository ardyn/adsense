@if ( $width == 0 )
<img src="http://placehold.it/300x75&text=Responsive%20Ad" alt="{{ $description }}" />
@else
<img src="http://placehold.it/{{$width}}x{{$height}}&text={{$name}}" alt="{{ $description }}" />
@endif
