@extends( admin_module_layout('master') )
@section('title', 'Page')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Page</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('page.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Pages</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @include( admin_module_view('partials.simple-messages') )

    @php
    $is_active      = (old('is_active') ?? $data->is_active ?? 1);

    $action     = route(admin_route('page.store'));
    if ( $is_update ) {
        $action = route(admin_route('page.update'), [$data->id]);
    }
    @endphp

    {{--@if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif--}}

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf @method( !$is_update ? 'POST' : 'PUT' )
        <div class="row">
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} Page</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.build-form') )
                    </div>
                </div>

                @include( admin_module_render('form.build-form-extras') )

            </div>
            <div class="col-md-6">
                @include( admin_module_render('form.extras') )
                @include( admin_module_render('form.seo-metadata') )
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-yarn">
                    <div class="card-footer">
                        @empty( $is_update )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="page.create">Save & New</button>
                        @endempty

                        @if( isAdmin() || getAuth()->can(\Perms::$PAGE['LIST']) )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="page.index">Save & Exit</button>
                            <button type="button" onclick="javascript:window.location='{{ route(admin_route('page.index')) }}'" class="btn btn-default">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection
@push('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/summernote/summernote-bs4.css') }}" />
@endpush
@push('scripts')
    <!-- Summernote -->
    <script src="{{ admin_asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $('.texteditor').summernote({
            width: '100%',
            height: 300,
            placeholder: 'Write page detail here...',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],

        });
    </script>
@endpush
