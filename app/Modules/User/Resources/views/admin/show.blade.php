@extends( admin_module_layout('master') )
@section('title', 'User Profile')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>User Profile</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">User Profile</li>
        </ol>
    </div>
@endsection
@section('content')

    @include( admin_module_view('partials.simple-messages') )

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{  $data->image_url }}" alt="{{ $data->full_name }}" />
                        </div>
                        <h3 class="profile-username text-center">{{ $data->full_name }}</h3>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $data->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <a class="float-right">{{ $data->phone }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Account Status</b> <a class="float-right">{{ $data->status }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Created Account</b> <a class="float-right">{{ $data->created_at }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-md-9">
                @php $tab = (\Session::get('account-tab') ?: 'contact-info');@endphp
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link @if($tab == 'contact-info' ) active @endif" href="#contact-info" data-toggle="tab">Contact Information</a></li>
                            <li class="nav-item"><a class="nav-link @if($tab == 'hospital-info' ) active @endif" href="#hospital-info" data-toggle="tab">Hospital</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="@if($tab == 'contact-info' ) active @endif tab-pane" id="contact-info">
                                @include( admin_module_render('user-details.contact-info') )
                            </div>
                            <div class="@if($tab == 'hospital-info' ) active @endif tab-pane" id="hospital-info">
                                @include( admin_module_render('user-details.hospital-info') )
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
