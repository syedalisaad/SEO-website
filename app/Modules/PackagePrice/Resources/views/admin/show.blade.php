@extends( admin_module_layout('master') )
@section('title', 'General Hospitals')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Hospital </h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route(admin_route('hospitalsurvey.list')) }}">Lists</a></li>
        </ol>
    </div>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">

                            <h3 class="profile-username text-center">{{ $data->name }}</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Stripe ID</b> <a class="float-right">{{ $data->stripe_product_price_id }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Description</b> <a class="float-right">{{ $data->description }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right" style="max-width: 60%"><input type="checkbox" name="is_active" {{ $data->is_active==1?'checked':'' }}></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    @php $tab = (\Session::get('PackagePrice') ?: 'monthly');@endphp
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link @if($tab == 'monthly' ) active @endif" href="#monthly" data-toggle="tab">Monthly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab == 'yearly' ) active @endif" href="#yearly" data-toggle="tab">Yearly</a>
                                </li>

                            </ul>
                            <a href="{{route(admin_route('add.package.price'),$data->stripe_poduct_id)}}">
                                <span class="btn btn-primary float-right"> Add Price</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="@if($tab == 'monthly' ) active @endif tab-pane" id="monthly">
                                    @include( admin_module_render('price.monthly.index','PackagePrice') )
                                </div>
                                <div class="@if($tab == 'yearly' ) active @endif tab-pane" id="yearly">
                                    @include( admin_module_render('price.yearly.index','PackagePrice') )
                                </div>

                            </div>
                        </div>
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
    <link rel="stylesheet"
          href="{{ asset('adminlite/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- DataTables -->
    <script src="{{ asset('adminlite/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlite/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlite/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            $('#monthly_table').DataTable({
                columnDefs: [
                    {
                        targets: [-1, -2],
                        render: function (data, type, full, meta) {
                            var table_date = {
                                '0000-00-00': {
                                    'title': 'Not Available',
                                    'class': 'label-light-primary'
                                },
                            };
                            if (typeof table_date[data] === 'undefined') {
                                return data;
                            }
                            return table_date[data].title;
                        },
                    },
                ],
            });
            $('#yearly_table').DataTable({
                columnDefs: [
                    {
                        targets: [-1, -2],
                        render: function (data, type, full, meta) {
                            var table_date = {
                                '0000-00-00': {
                                    'title': 'Not Available',
                                    'class': 'label-light-primary'
                                },
                            };
                            if (typeof table_date[data] === 'undefined') {
                                return data;
                            }
                            return table_date[data].title;
                        },
                    },
                ],
            });
        });
    </script>
@endpush
