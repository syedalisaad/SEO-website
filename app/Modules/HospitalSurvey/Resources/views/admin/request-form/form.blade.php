@extends( admin_module_layout('master') )
@section('title', 'Hospital Update Information')
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Hospital Update Information</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard') )}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route(admin_route('user.index')) }}">Lists</a></li>
            <li class="breadcrumb-item active"><a href="{{ route(admin_route('hospitalsurvey.change_info_req')) }}">Hospital Update Information</a></li>
        </ol>
    </div>
@endsection

@section('content')
<div class="container-fluid">

    @include( admin_module_view('partials.simple-messages') )

    <form role="form" class="dash-upload2" action="{{ route(admin_route('hospitalsurvey.submit.change_info_req'), [$data->id]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">

            <div class="col-md-6">
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Hospital Request Information</h3>
                    </div>
                    <div class="card-body">
                        @include( admin_module_render('request-form.form-builder', 'HospitalSurvey') )
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @if( !$data->is_publish )
                <div class="card card-yarn">
                    <div class="card-header">
                        <h3 class="card-title">Previous Hospital Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $data->hospital->facility_name  }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $data->hospital->phone_number  }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>{{ $data->hospital->ref_url  }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="row">
            <div class="col-md-12">
                @error('formsubmit')<span class="error invalid-feedback display-block mt-2 mb-2">{{ $message }}</span>@enderror
                <div class="card card-primary">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-yarn" name="formsubmit" >Submit</button>
                        <button type="button" onclick="javascript:window.location='{{ route(admin_route('hospitalsurvey.change_info_req')) }}'" class="btn btn-default">Cancel</button>
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
        $('.remove_video').on('click', function () {


            Swal.fire({
                html: 'Are your sure you want to delete this video?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    // alert();
                    var token ="<?php echo csrf_token() ?>";

                    $.ajax({
                        type:'POST',
                        url:'{{route(front_route('user.ajax_remove_video'))}}',
                        data:{video:$(this).data('colume'),id:$(this).data('id')},
                        success:function(msg) {
                            console.log(msg.status);
                            if(msg.status == true)
                            {
                                // $(this).closest('div').css("display",'none!important')
                                Swal.fire('deleted!', '', 'success')

                            }
                            location.reload();
                        }


                    });

                } else if (result.isDenied) {
                    Swal.fire(
                        '', 'Changes are not saved', 'info')
                }
            });


        })

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

