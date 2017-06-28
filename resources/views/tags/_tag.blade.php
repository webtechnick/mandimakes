<div class="col-sm-6 col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('items', ['tags' => $tag->slug]) }}">
                <div class="caption text-center">
                    <h3>{{ $tag->name }}</h3>
                    @if ($user AND $user->isAdmin())
                        <a href="{{ route('admin.tags.edit', [$tag]) }}" class="btn btn-default">Edit</a>
                    @endif
                </div>
            </a>
        </div>
    </div>
</div>