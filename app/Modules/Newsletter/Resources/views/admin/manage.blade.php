@extends( admin_module_layout('master') )
@section('title', admin_module_lang('lang.default.title'))
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>{{ admin_module_lang('lang.default.title') }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ admin_module_lang('lang.manage.list', 'Lists', true) }}</li>
        </ol>
    </div>
@endsection
@section('content')
<section class="content">

    <div class="container-fluid">

        @include( admin_module_view('partials.simple-messages') )

        @include( admin_module_view('partials.manage-action-buttons'))

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ admin_module_lang('lang.default.title') }} {{ admin_module_lang('lang.manage.list', 'Lists', true) }}</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th width="60%">Email</th>
                                    <th>IP Address</th>
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
        ajax:'{{ route(admin_route('newsletter.ajaxlist')) }}',
        order: [[ 3, "desc" ]],
        columns: [
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false
            },
            {data: 'email', name: 'email'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'created_at', name: 'created_at'},
        ]
    });
});
</script>
@endpush
