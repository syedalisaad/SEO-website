@extends( admin_module_layout('master') )
@section('title', 'Media Storage')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Media Library</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Media Library</li>
        </ol>
    </div>
@endsection
@section('content')
<div class="container-fluid">
    @include( admin_module_view('partials.storage-manager') )
</div>
@stop
