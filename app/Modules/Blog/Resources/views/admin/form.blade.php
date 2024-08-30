@extends( admin_module_layout('master') )
@section('title', 'Blog')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Blog</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('blog.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Blog</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @include( admin_module_view('partials.simple-messages') )

    @php
    $is_active      = (old('is_active') ?? $data->is_active ?? 1);

    $action     = route(admin_route('blog.store'));
    if ( $is_update ) {
        $action = route(admin_route('blog.update'), [$data->id]);
    }
    @endphp

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf @method( !$is_update ? 'POST' : 'PUT' )
        <div class="row">
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} Blog</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.build-form') )
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Tags</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.tags') )
                    </div>
                </div>
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
                <div class="card card-yarn">
                    <div class="card-footer">
                        @empty( $is_update )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="blog.create">Save & New</button>
                        @endempty

                        @if( isAdmin() || getAuth()->can(\Perms::$BLOG['LIST']) )
                            <button type="submit" class="btn btn-yarn" name="formsubmit" value="blog.index">Save & Exit</button>
                            <button type="button" onclick="javascript:window.location='{{ route(admin_route('blog.index')) }}'" class="btn btn-default">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
