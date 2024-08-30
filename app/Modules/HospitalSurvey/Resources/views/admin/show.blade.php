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

                            <h3 class="profile-username text-center">{{ $data->facility_name }}</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{ $data->phone_number }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Zip Code</b> <a class="float-right">{{ $data->zip_code }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>State</b> <a class="float-right">{{ $data->state }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>City</b> <a class="float-right">{{ $data->city }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>County</b> <a class="float-right">{{ $data->county_name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Address</b> <a class="float-right"
                                                      style="max-width: 60%">{{ $data->address }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- About Details -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Additional Information</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Hospital Type</b> <a class="float-right">{{ $data->hospital_type }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Hospital Ownership</b> <a class="float-right">{{ $data->hospital_ownership }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Emergency Services</b> <a class="float-right">{{ $data->emergency_services }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Hospital Overall Rating</b> <a
                                        class="float-right">{{ $data->hospital_overall_rating }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-md-9">
                    @php $tab = (\Session::get('HospitalSurvey') ?: 'infection');@endphp
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link @if($tab == 'infection' ) active @endif"
                                                        href="#infection" data-toggle="tab">Patient Infection</a></li>
                                <li class="nav-item"><a class="nav-link @if($tab == 'survey' ) active @endif"
                                                        href="#survey" data-toggle="tab">Patient Experience</a></li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab == 'death_complication' ) active @endif"
                                       href="#death_complication" data-toggle="tab">Patient Death & Complication</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab == 'unplanned_visit' ) active @endif"
                                       href="#unplanned_visit" data-toggle="tab">Patient Readmission</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if($tab == 'timely_effective_care' ) active @endif"
                                       href="#timely_effective_care" data-toggle="tab">Patient Speed Of Care</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="@if($tab == 'infection' ) active @endif tab-pane" id="infection">
                                    @include( admin_module_render('hospital-view-tabs.patient_infection','HospitalSurvey') )
                                </div>
                                <div class="@if($tab == 'survey' ) active @endif tab-pane" id="survey">
                                    @include( admin_module_render('hospital-view-tabs.patient_survey','HospitalSurvey') )
                                </div>
                                <div class="@if($tab == 'death_complication' ) active @endif tab-pane"
                                     id="death_complication">
                                    @include( admin_module_render('hospital-view-tabs.patient_death_complication','HospitalSurvey') )
                                </div>
                                <div class="@if($tab == 'unplanned_visit' ) active @endif tab-pane"
                                     id="unplanned_visit">
                                    @include( admin_module_render('hospital-view-tabs.patient_unplanned_visit','HospitalSurvey') )
                                </div>
                                <div class="@if($tab == 'unplanned_visit' ) active @endif tab-pane"
                                     id="unplanned_visit">
                                    @include( admin_module_render('hospital-view-tabs.patient_unplanned_visit','HospitalSurvey') )
                                </div>
                                <div class="@if($tab == 'timely_effective_care' ) active @endif tab-pane"
                                     id="timely_effective_care">
                                    @include( admin_module_render('hospital-view-tabs.patient_timely_effective_care','HospitalSurvey') )
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
            $('#survey_table').DataTable({
                pageLength: 50,

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
        $(document).ready(function () {
            $('#infection_table').DataTable({
                pageLength: 50,
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
        $(document).ready(function () {
            $('#death_complication_table').DataTable({
                pageLength: 50,
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
        $(document).ready(function () {
            $('#unplanned_visit_table').DataTable({
                pageLength: 50,
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
        $(document).ready(function () {
            $('#timely_effective_care_table').DataTable({
                pageLength: 50,
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
