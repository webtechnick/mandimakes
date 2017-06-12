<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Type: </label>
            {{ Form::select('shipping_type_id', \App\ShippingType::pluck('name','id'), null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group">
            <label for="price_dollars">Price: </label>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                {{ Form::text('price_dollars', null, ['placeholder' => '0', 'class' => 'form-control', 'required']) }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Name: </label>
            {{ Form::text('name', null, ['placeholder' => 'Title', 'class' => 'form-control', 'required']) }}
        </div>
    </div>
</div>