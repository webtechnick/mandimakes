<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Title: </label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" @isset($item) value="{{ $item->title }}" @else value="{{ old('title') }}" @endisset required>
        </div>
        <div class="form-group">
            <label for="status">Status: </label>
            <select name="status" id="status" class="form-control" required>
                @foreach (App\Item::$statuses as $val => $status)
                    @isset($item)
                        @if($item->status == $val)
                            <option value="{{ $val }}" selected>{{ $status }}</option>
                        @else
                            <option value="{{ $val }}">{{ $status }}</option>
                        @endif
                    @else
                        <option value="{{ $val }}">{{ $status }}</option>
                    @endisset
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="qty">Quantity: </label>
            <input type="text" class="form-control" name="qty" id="qty" placeholder="Quantity" @isset($item) value="{{ $item->qty }}" @else value="{{ old('qty') }}" @endisset">
        </div>
        <div class="form-group">
            <label for="price_dollars">Price: </label>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" name="price_dollars" id="price_dollars" placeholder="Price" @isset($item) value="{{ $item->price_dollars }}" @else value="{{ old('price_dollars') }}" @endisset required>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description">Description: </label>
    <textarea class="form-control tinymce" name="description" id="description" rows="5">@isset($item){{ $item->description }}@else{{ old('description') }}@endisset</textarea>
</div>
<div class="form-group">
    <label for="short_description">Short Description: </label>
    <textarea class="form-control" name="short_description" id="short_description" rows="2">@isset($item){{ $item->short_description }}@else{{ old('short_description') }}@endisset</textarea>
</div>
<div class="form-group">
    <label for="tagString">Tags: (separate by commas)</label>
    <input type="text" class="form-control" name="tagString" id="tagString" placeholder="Tag, Tag, Tag" @isset($item) value="{{ $item->tagString }}" @else value="{{ old('tagStting') }}" @endisset">
</div>