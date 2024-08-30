@extends( admin_module_layout('master') )
@section('title', 'Category')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Category</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard') )}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('category.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Categories</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @php
    $is_active = (old('is_active ')?:1);

    if( $is_update ) {
        $is_active = $data->is_active;
    }

    $action = route(admin_route('category.store'));

    if ( $is_update ) {
        $action = route(admin_route('category.update'), [$data->id]);
    }
    @endphp

    @include( admin_module_view('partials.simple-messages') )

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf @method( !$is_update ? 'POST' : 'PUT' )

        <div class="row">
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} Category</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.form-builder') )
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Search Engine Optimization Information</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.seo-metadata') )
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @error('formsubmit')<span class="error invalid-feedback display-block mt-2 mb-2">{{ $message }}</span>@enderror
                <div class="card card-primary">
                    <div class="card-footer">
                        @empty( $is_update )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="category.create">Save & New</button>
                        @endempty
                        @if( isAdmin() || getAuth()->can(\Perms::$CATEGORY['LIST']) )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="category.index">Save & Exit</button>
                            <button type="button" onclick="javascript:window.location='{{ route(admin_route('category.index')) }}'" class="btn btn-default">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
