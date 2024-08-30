@extends( admin_module_layout('master') )
@section('title', 'Hospitals - Request Information')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Hospitals - Request Information</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
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
                            <h3 class="card-title">Hospitals - Request Information</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead style="text-transform: capitalize;">
                                <tr>
                                    <th width="7%">Actions</th>
                                    <th>User</th>
                                    <th>Facility Name</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Image</th>
                                    <th>Reference URL</th>
                                    <th>Approved</th>
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
    <link rel="stylesheet" href="{{ admin_asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- DataTables -->
    <script src="{{ admin_asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ admin_asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ admin_asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script>
        $(function () {

            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route(admin_route('hospitalsurvey.ajax.change_info_req')) }}',
                order: [[1, "desc"]],
                columns: [
                    {
                        data: 'action', name: 'action',
                        orderable: false, searchable: false
                    },
                    {data: 'user_id', name: 'user_id'},
                    {data: 'hospital_id', name: 'hospital_id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {
                        data: 'logo_image', name: 'logo_image',
                        orderable: false, searchable: false
                    },
                    {data: 'ref_url', name: 'ref_url'},
                    {data: 'is_approved', name: 'is_approved'},
                ]
            });
        });
    </script>
@endpush
