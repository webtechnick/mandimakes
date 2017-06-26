
<div class="form-group">
    <label for="name">Name: </label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Name" @isset($tag) value="{{ $tag->name }}" @else value="{{ old('name') }}" @endisset required>
</div>

<div class="form-group">
    <label for="slug">Slug: </label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" @isset($tag) value="{{ $tag->slug }}" @else value="{{ old('slug') }}" @endisset>
    <p class="help-block">If left empty, a slug will automatically be genereated.</p>
</div>

<div class="checkbox">
    <label>
        {{ Form::hidden('is_nav', 0) }}
        {{ Form::checkbox('is_nav', 1, isset($tag) ? $tag->is_nav : true) }} Show In Top Navigation
    </label>
</div>