@if ($user AND $user->isAdmin())
<div class="dropdown admin-box pull-left">
    <span class="glyphicon-lg hand glyphicon glyphicon-cog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        @if ($photo->isPrimary())
            <li><a href="/admin/photos/{{ $photo->id }}/makeprimary"><span class="glyphicon glyphicon-check"></span> Force Primary</a></li>
        @else
            <li><a href="/admin/photos/{{ $photo->id }}/makeprimary"><span class="glyphicon glyphicon-check"></span> Make Primary</a></li>
        @endif
        <li class="divider"></li>
        <li><a href="/admin/photos/{{ $photo->id }}/delete" class="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</a></li>
    </ul>
</div>
@endif