@extends( admin_module_layout('master') )
@section('title', 'General Hospitals')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Stripe Package</h1>
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

            @if( isAdmin() || getAuth()->can(\Perms::$PAGE['ADD']) )

                @php $actions = []; @endphp

                {{--@if( isAdmin() || getAuth()->can(\Perms::$PAGE['ADD']) )
                    @php $actions['added'] = admin_route('page.create'); @endphp
                @endif--}}
                <br/>

                @include( admin_module_view('partials.manage-action-buttons'), [
                    'actions' => $actions
                ])
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Stripe Packages List</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead style="text-transform: capitalize;">
                                <tr>
                                    <th>Name</th>
                                    <th>Product Stripe ID</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th width="10%">Actions</th>
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
                ajax: '{{ route(admin_route('packageprice.ajax.manageable')) }}',
                order: [[5, "desc"]],
                columns: [

                    {data: 'name', name: 'name'},
                    {data: 'stripe_product_price_id', name: 'stripe_product_price_id'},
                    {data: 'description', name: 'description'},
                    {data: 'is_active', name: 'is_active'},

                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'action', name: 'action',
                        orderable: false, searchable: false
                    },

                ]
            });
        });
    </script>
@endpush
