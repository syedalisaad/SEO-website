@extends( admin_module_layout('master') )
@section('title', 'Users')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Users {{ $is_trash ? '(Trashed)': '' }}</h1>
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

        @if( isAdmin() || getAuth()->can(\Perms::$USER['ADD']) )
            @include( admin_module_view('partials.manage-action-buttons'), [
                'actions' => [ 'added' => admin_route('user.create'), 'deleted' => admin_route('user.index') ]
            ])
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users List {{ $is_trash ? '(Trashed)': '' }}</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">Actions</th>
                                    <th>Hospital</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Profile</th>
                                    <th>Subscription</th>
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
        ajax:'{{ route(admin_route( $is_trash ? 'user.ajax.trash.manageable' : 'user.ajax.manageable' )) }}',
        order: [[ 8, "desc" ]],
        columns: [
            {
               data: 'action', name: 'action',
               orderable: false, searchable: false
            },
            {
                data: 'hospital', name: 'hospital',
                orderable: false, searchable: false
            },
            {data: 'full_name', name: 'first_name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {
                data: 'source_image', name: 'source_image',
                orderable: false, searchable: false
            },
            {
                data: 'subscription_info', name: 'subscription_info',
                orderable: false, searchable: false
            },
            {data: 'is_active', name: 'is_active'},
            {data: 'created_at', name: 'created_at'},
        ]
    });
});
</script>
@endpush
