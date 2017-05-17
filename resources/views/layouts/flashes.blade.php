@if ( session()->has('flash') )
    <div class="alert alert-{{ session()->get('flash.type') }}">
        {{ session()->get('flash.message') }}
    </div>
@endif