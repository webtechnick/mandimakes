<div class="col-sm-6 col-md-3">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="hand" onclick="location.href='/?tags={{ $tag->slug }}'">
                <div class="caption text-center">
                    <h3>{{ $tag->name }}</h3>
                    @if ($user AND $user->isAdmin())
                        <a href="{{ route('admin.tags.edit', [$tag]) }}" class="btn btn-default">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>