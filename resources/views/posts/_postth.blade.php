
@if ($post)
<div class="panel panel-default hand" onclick="location.href='/blog/{{ $post->slug }}'">
    <div class="panel-heading">
        <h3>
            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a> |
            <small>Published by {{ $post->author->name }} {{ $post->published_at->diffForHumans() }}</small>
        </h3>
    </div>
    <div class="panel-body">
        <p>{!! $post->short_body !!}</p>
    </div>
</div>
@endif