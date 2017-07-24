@if ($item->primaryPhoto)
<div class="row">
    <div class="col-md-12 mb20 photo-bucket">
        @include('photos._admindropdown', ['photo' => $item->primaryPhoto])
        <a href="/{{$item->primaryPhoto->path}}" data-lightbox="item{{ $item->id }}" class="thumbnail">
            <img class="img-rounded img-responsive" src="{{ $item->primaryPhoto->thumbnail(500) }}" alt="">
        </a>
    </div>
</div>
@endif
@foreach ($item->photos->chunk(3) as $set)
<div class="row">
    @foreach ($set as $photo)
        @if(!$item->primaryPhoto || $photo->id != $item->primaryPhoto->id)
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