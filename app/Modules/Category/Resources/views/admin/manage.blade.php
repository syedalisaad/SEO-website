@extends( admin_module_layout('master') )
@section('title', 'Categories')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Categories</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard'))}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Lists</li>
        </ol>
    </div>
@endsection
@section('content')
<section class="content">

    <div class="container-fluid">

        @include( admin_module_view('partials.simple-messages') )

        @if( isAdmin() || getAuth()->can(\Perms::$CATEGORY['ADD']) )
            @include( admin_module_view('partials.manage-action-buttons'), [
                'actions' => [ 'added' => admin_route('category.create') ]
            ])
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories List</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th width="50%">Name</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
    <!-- DataTables -->
     <link rel="stylesheet" href="{{ asset('adminlite/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
     <link rel="stylesheet" href="{{ asset('adminlite/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables -->
<script src="{{ asset('adminlite/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlite/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlite/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

<script>
$(function () {
    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax:'{{ route(admin_route('category.ajax.manageable')) }}',
        order: [[ 4, "desc" ]],
        columns: [
            {
               data: 'action', name: 'action',
               orderable: false, searchable: false
            },
            {data: 'name', name: 'name'},
            {
                data: 'source_image', name: 'source_image',
                orderable: false, searchable: false
            },
            {data: 'is_active', name: 'is_active'},
            {data: 'created_at', name: 'created_at'},
        ]
    });
});
</script>
@endpush
