@extends( admin_module_layout('master') )
@section('title', 'Permission')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Permission</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('permission.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Permission</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @php
    $is_active  = (old('is_active') ?? $data->is_active  ?? 1);

    $action     = route(admin_route('permission.store'));
    if ( $is_update ) {
        $action = route(admin_route('permission.update'), [$data->id]);
    }
    @endphp

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf @method( !$is_update ? 'POST' : 'PUT' )
        <div class="row">
            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} Permission</h3>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm-8">
                                <label class="cust-label">Name <strong style="color:#c00">*</strong></label>
                                <input type="text" name="name" value="{{ old('name') ?? $data->name ?? null }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Name">
                                @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                       <button type="submit" class="btn btn-yarn">Save</button>
                       <button type="button" onclick="javascript:window.location='{{ route(admin_route('permission.index')) }}'" class="btn btn-default">Cancel</button>
                   </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
