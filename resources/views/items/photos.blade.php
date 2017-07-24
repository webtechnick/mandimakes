@foreach ($item->photos->chunk(3) as $set)
<div class="row">
    @foreach ($set as $photo)
        @if($loop->first)
            <div class="col-md-12 mb20 photo-bucket">
                @include('photos._admindropdown')
                <a href="/{{$photo->path}}" data-lightbox="item{{ $item->id }}" class="thumbnail">
                    <img class="img-rounded img-responsive" src="{{ $photo->thumbnail(500) }}" alt="">
                </a>
            </div>
        @else
            <div class="col-md-4 mb20 photo-bucket">
                @include('photos._admindropdown')
                <a href="/{{$photo->path}}" data-lightbox="item{{ $item->id }}" class="thumbnail">
                    <img class="img-rounded img-responsive" src="{{ $photo->thumbnail(200) }}" alt="">
                </a>
            </div>
        @endif
    @endforeach
</div>
@endforeach