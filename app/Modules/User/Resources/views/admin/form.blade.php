@extends( admin_module_layout('master') )
@section('title', 'User')
@php $is_update = (isset($data) && $data); @endphp
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>User</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard') )}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('user.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active">{{ !$is_update ? 'Add New' : 'Edit' }} Agent</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @php
    $is_active = (old('is_active ')?:1);

    if( $is_update ) {
        $is_active = $data->is_active;
    }

    $action = route(admin_route('user.store'));

    if ( $is_update ) {
        $action = route(admin_route('user.update'), [$data->id]);
    }
    @endphp

{{--    @if($errors->any())--}}
{{--        {{ dump($errors) }}--}}
{{--        {{ implode('', $errors->all('<div>:message</div>')) }}--}}
{{--    @endif--}}

    @include( admin_module_view('partials.simple-messages') )

    <form role="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf @method( !$is_update ? 'POST' : 'PUT' )
        <div class="row">

            <div class="col-md-12">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">{{ !$is_update ? 'Add New' : 'Edit' }} User</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.form-builder') )
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                {{--<div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Hospital Information</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('form.additional-details') )
                    </div>
                </div>--}}
                @if( isset($data) && $data->user_order )
                    <div class="card card-yarn">
                        <div class="card-header">
                            <h3 class="card-title">Subscription Information</h3>
                        </div>
                        <div class="card-body">
                            @include( admin_module_render('form.subscription-details') )
                        </div>
                    </div>
                @endif
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
                            <button type="button" onclick="javascript:window.location='{{ route(admin_route('user.index')) }}'" class="btn btn-default">Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection
@push('scripts')
<script>
    $(function(){

        $('.constPwdAction').on('click', function(){

            const pwd_icon   = $(this).find('.input-group-text i').attr('class').replace(/[ |fa|-]/g, '');

            $('input[name=password]').attr('type', pwd_icon == 'eye' ? 'text': 'password');

            var remove_pwd_icon = (pwd_icon == 'eye' ? 'fa-eye' : 'fa-eye-slash');
            var add_pwd_icon    = (pwd_icon == 'eye' ? 'fa-eye-slash' : 'fa-eye');

            $(this).find('.input-group-text i').removeClass(remove_pwd_icon).addClass(add_pwd_icon)
        });
    })
</script>
@endpush

