@if ( $width == 0 )
<div style="width:100%;min-width:225px;max-width:970px;background-color:#E6F2FF;text-align:center"><img src="http://placehold.it/225x75/E6F2FF&text=Responsive%20Ad" alt="{{ $description }}" /></div>
@else
<img src="http://placehold.it/{{$width}}x{{$height}}&text={{$name}}" alt="{{ $description }}" />
@endif
