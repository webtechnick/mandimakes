<div class="col-md-4">
    <div class="panel panel-default" style="cursor:pointer;" onclick="location.href='/item/{{ $item->id }}'">
        <div class="panel-heading">
            {{ $item->title }}
        </div>
        <div class="panel-body" style="height: 150px;">
            {{ $item->short_description }}
        </div>
    </div>
</div>