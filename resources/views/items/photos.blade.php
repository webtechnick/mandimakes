@foreach ($item->photos->chunk(3) as $set)
<div class="row">
    @foreach ($set as $photo)
        <div class="col-md-4 mb20 photo-bucket">
            @include('photos._admindropdown')
            <a href="/{{$photo->path}}" data-lightbox="item{{ $item->id }}" class="thumbnail">
                <img class="img-rounded" src="{{ $photo->thumbnail(200) }}" alt="">
            </a>
        </div>
    @endforeach
</div>
@endforeach