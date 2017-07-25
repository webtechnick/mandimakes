<div class="form-group">
    <label for="status">Title: </label>
    {{ Form::text('title', null, ['placeholder' => 'Title of Article', 'class' => 'form-control', 'required']) }}
</div>
<div class="form-group">
    <label for="slug">Slug: </label>
    {{ Form::text('slug', null, ['placeholder' => 'title-of-article', 'class' => 'form-control']) }}
    <small>If left blank will be generated for you</small>
</div>
<div class="form-group">
    <label for="published_at">Publish Date: </label>
    {{ Form::text('published_at', date('Y-m-d'), ['placeholder' => 'Published Date', 'class' => 'form-control', 'required']) }}
</div>
<div class="checkbox">
    <label>
        {{ Form::hidden('is_published', 0) }}
        {{ Form::checkbox('is_published', 1, isset($post) ? $post->is_published : true) }} Active
    </label>
</div>
<div class="form-group">
    <label for="body">Body: </label>
    {{ Form::textarea('body', null, ['class' => 'form-control tinymce']) }}
</div>
<div class="form-group">
    <label for="short_body">Short: </label>
    <small>If left blank will be generated for you</small>
    {{ Form::textarea('short_body', null, ['class' => 'form-control', 'rows' => 5]) }}
</div>