@extends( admin_module_layout('master') )
@section('title', 'Package Price')
@section('breadcrumbs')

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <div class="col-sm-6">
        <h1>Hospital </h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route(admin_route('packageprice.list')) }}">Lists</a></li>
        </ol>
    </div>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">


            <form role="form" action="{{route(admin_route('create.package.price'))}}" method="POST">
                @csrf @method( 'POST' )

                <input name="product_stripe_id" value="{{ $data->product_stripe_id }}" type="hidden">
                <input name="product_id" value="{{ $data->id }}" type="hidden">


                <div class="row">

                    <div class="col-md-6">
                        <div class="card card-yarn">
                            <div class="card-header">
                                <h3 class="card-title">Package Information</h3>
                            </div>
                            <div class="card-body">

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Package NAme</b> <a class="float-right">{{ $data->product_name }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Stripe ID</b> <a class="float-right">{{ $data->stripe_product_price_id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Description</b> <a class="float-right">{{ $data->description }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-yarn">
                            <div class="card-header">
                                <h3 class="card-title">Add New Price</h3>
                            </div>

                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-sm-6">
                                        <label class="cust-label">Price <strong style="color:#c00">*</strong></label>
                                        <div class="input-group">
                                            <input type="number" name="price" value="{{ old('price') }}" class="form-control form-control-sm @error('price') is-invalid @enderror" placeholder="price">
                                            @error('price')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="cust-label">Recurring <strong style="color:#c00">*</strong></label>
                                        <div class="input-group">
                                            <select name="recurring" value="{{ old('recurring') }}" class="form-control form-control-sm @error('recurring') is-invalid @enderror" >
                                                <option>Select Recurring</option>
                                                <option value="1">Monthly</option>
                                                <option value="2">Yearly</option>
                                            </select>
                                            @error('recurring')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="cust-label">Visibilty <strong style="color:#c00">*</strong></label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="is_active" {{old('is_active')==1 ?? 'checked'}} class="custom-control-input" id="isActive" value="1">
                                                <label class="custom-control-label" for="isActive">Active</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        @error('formsubmit')<span class="error invalid-feedback display-block mt-2 mb-2">{{ $message }}</span>@enderror
                        <div class="card card-primary">
                            <div class="card-footer">
                                @empty( $is_update )
                                    <button type="submit" class="btn btn-yarn" name="formsubmit" value="user.create">Save & New</button>
                                @endempty

                                @if( isAdmin() || getAuth()->can(\Perms::$USER['LIST']) )
                                    <button type="submit" class="btn btn-yarn" name="formsubmit" value="user.index">Save & Exit</button>
                                    <button type="button" onclick="javascript:window.location='{{ route(admin_route('add.package.price'),$data->stripe_poduct_id) }}'" class="btn btn-default">Cancel</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </form>

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
