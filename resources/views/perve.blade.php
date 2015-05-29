@foreach ($media->data as $image)
    <img src="{{$image->images->standard_resolution->url}}">
@endforeach