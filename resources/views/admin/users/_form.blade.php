<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Name: </label>
            {{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group">
            <label for="title">Email: </label>
            {{ Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Group: </label>
            {{ Form::select('group', ['user' => 'user', 'admin' => 'admin'], null, ['class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>