@extends( admin_module_layout('master') )
@section('title', 'General Hospitals')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>General Hospitals</h1>
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
                            <h3 class="card-title">General Hospitals List</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead style="text-transform: capitalize;">
                                <tr>
                                    <th width="10%">Actions</th>
                                    <th>facility ID</th>
                                    <th>facility name</th>
                                    <th>phone number</th>
                                    <th>address</th>
                                    <th>county name</th>
                                    <th>state</th>
                                    <th>city</th>
                                    <th>zip code</th>
                                    <th>hospital type</th>
                                    <th>hospital ownership</th>
                                    <th>emergency services</th>
                                    <th>hospital overall rating</th>
                                    <th>ref url</th>
                                    <th>extras</th>
                                    <th>is active</th>
                                    <th>API</th>
                                    <th>source image</th>
                                    <th>seo metadata</th>
                                    <th>created by</th>
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
                ajax: '{{ route(admin_route('hospitalsurvey.ajax.manageable')) }}',
                order: [[3, "desc"]],
                columns: [
                    {
                        data: 'action', name: 'action',
                        orderable: false, searchable: false
                    },
                    {data: 'facility_id', name: 'facility_id'},
                    {data: 'facility_name', name: 'facility_name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'address', name: 'address'},
                    {data: 'county_name', name: 'county_name'},
                    {data: 'state', name: 'state'},
                    {data: 'city', name: 'city'},
                    {data: 'zip_code', name: 'zip_code'},
                    {data: 'hospital_type', name: 'hospital_type'},
                    {data: 'hospital_ownership', name: 'hospital_ownership'},
                    {data: 'emergency_services', name: 'emergency_services'},
                    {data: 'hospital_overall_rating', name: 'hospital_overall_rating'},
                    {data: 'ref_url', name: 'ref_url'},
                    {data: 'extras', name: 'extras'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'is_api', name: 'is_api'},
                    {data: 'source_image', name: 'source_image'},
                    {data: 'seo_metadata', name: 'seo_metadata'},
                    {data: 'created_by', name: 'created_by'},
                ]
            });
        });
    </script>
@endpush
