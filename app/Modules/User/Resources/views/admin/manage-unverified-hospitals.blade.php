@extends( admin_module_layout('master') )
@section('title', 'Approved Hospitals')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Approved Hospitals</h1>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Approved Hospitals</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="9%">Actions</th>
                                    <th>User</th>
                                    <th>Hospital</th>
                                    <th>Hospital Status</th>
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
        ajax:'{{ route(admin_route( 'user.ajax.hospital.unverified.manageable' )) }}',
        order: [[ 1, "desc" ]],
        columns: [
            {
               data: 'action', name: 'action',
               orderable: false, searchable: false
            },
            {data: 'full_name', name: 'users.first_name'},
            {data: 'hospital_id', name: 'ud.hospital_id'},
            {
                data: 'is_hospital_approved', name: 'ud.is_hospital_approved',
                orderable: false, searchable: false
            },
            {data: 'created_at', name: 'created_at'},
        ]
    });
});
</script>
@endpush
