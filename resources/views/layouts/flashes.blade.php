@if ( session()->has('flash') )
    <div class="text-center alert alert-dismissable alert-{{ session()->get('flash.type') }}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session()->get('flash.message') }}
    </div>
@endif