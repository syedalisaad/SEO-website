@extends( admin_module_layout('master') )
@section('title', 'Orders - Delivered')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Hospital Payments</h1>
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
                        <h3 class="card-title">Hospital Payments</h3>
                    </div>
                    <div class="card-body">
                        <table id="datatableAjax" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="8%">Actions</th>
                                    <th width="15%">User</th>
                                    <th width="30%">Package</th>
                                    <th>Total</th>
                                    <th>Note</th>
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
    $('#datatableAjax').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax:'{{ route(admin_route('order.ajax.delivered.manageable')) }}',
        order: [[ 6, "desc" ]],
        columns: [
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false
            },
            {data: 'user_id', name: 'orders.user_id'},
            {
                data: 'total_items', name: 'total_items',
                orderable: false, searchable: false
            },
            {data: 'total_amount', name: 'total_amount', orderable: false, searchable: false},
            {data: 'order_note', name: 'orders.order_note'},
            {data: 'for_order_status', name: 'orders.for_order_status'},
            {data: 'created_at', name: 'orders.created_at'},
        ]
    });
});
</script>
@endpush
