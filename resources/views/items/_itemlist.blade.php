<div class="row hand" onclick="location.href='/item/{{ $item->id }}'">
    <div class="col-md-5">
        @if ($item->hasPrimaryPhoto())
        <div class="text-center">
            {!! $item->pic(200) !!}
        </div>
        @endif
    </div>
    <div class="col-md-5">
        <h3>{{ $item->title }}</h3>
        <p>{!! $item->short_description !!}</p>
        <p class="text-center">
            <a href="{{ route('carts.add', [$item]) }}" class="btn btn-primary btn-lg">Add To Cart <i class="fa fa-cart-plus" aria-hidden="true"></i></a>
            @if ($user AND $user->isAdmin())
                <a href="{{ route('admin.items.edit', [$item]) }}" class="btn btn-default">Edit</a>
            @endif
        </p>
    </div>
</div>