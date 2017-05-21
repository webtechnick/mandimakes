@extends('layouts.admin')

@section('styles')
<link href="{{ asset('css/libs.css') }}" rel="stylesheet">
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit Item</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            <form action="/admin/items/edit/{{ $item->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                @include('admin.items._form', ['item' => $item])
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Edit Item</button>
                </div>
            </form>


            <h2>Photos</h2>

            <form id="addPhotosForm" action="/admin/items/{{ $item->id }}/photos" method="POST" class="bluedashed dropzone">
                {{ csrf_field() }}
            </form>

            @section('scripts')
                <script>
                    Dropzone.options.addPhotosForm = {
                        init: function () {
                            this.on("queuecomplete", function(file) {
                                // location.reload();
                            });
                        },
                        paramName: 'photo',
                        maxFileSize: 3,
                        acceptedFiles: '.jpg, .jpeg, .png, .gif'
                    }
                </script>
            @endsection

        </div>
    </div>
@endsection