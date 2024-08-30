<style>

    .dash-upload2 small {
        font-size: 100%;
    }

    .dash-upload2 small img {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

</style>


<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Name <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="name" value="{{ old('name',  $data->name ?? null) }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Hospital Name">
            @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-6">
        <label class="cust-label">Phone <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="phone_number" minlength="10" maxlength="10" id="pop_phone" value="{{ old('phone_number', $data->phone_number ?? null) }}" class="form-control form-control-sm @error('phone_number') is-invalid @enderror" placeholder="Phone Number">
            @error('phone_number')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-6">
        <label class="cust-label">Reference <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="ref_url" value="{{ old('ref_url', $data->ref_url ?? null) }}" class="form-control form-control-sm @error('ref_url') is-invalid @enderror" placeholder="Reference URL">
            @error('ref_url')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-2">
        @php $is_approved = old('is_approved', $data->is_approved ?? 0); @endphp
        <div class="form-group">
            <label class="cust-label">Approved <strong style="color:#c00">*</strong></label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_approved" {{ $is_approved == 1 ? 'checked' : '' }} class="custom-control-input" id="isApproved" value="1">
                <label class="custom-control-label" for="isApproved">Approved</label>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row form-group">

        <label class="lable">Logo Image </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="logo_image">
            <label class="custom-file-label @error('logo_image') is-invalid @enderror" for="customFile"></label>
            @error('logo_image')<span class="error invalid-feedback mt-10" style="margin-top: 1.25rem!important;">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-12 mt-4">
            <small>
                <div class="row d-flex align-items-center">
                    <div class="col-md-6">
                        <div class="upload-data py-2">
                            Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>

                        </div>
                        <div class="upload-data py-2">
                            Minimum Upload Size: <kbd>width:300px height:300px</kbd>

                        </div>
                        <div class="upload-data py-2">
                            Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        @if( isset($data) && $data->image_url_logo )
                            <img class="up-img" src="{{ $data->image_url_logo  }}">
                        @endif
                    </div>
                </div>
            </small>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row form-group">
        <label class="lable">Right Image </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="right_image">
            <label class="custom-file-label @error('right_image') is-invalid @enderror" for="customFile"></label>
            @error('right_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-12">
            <small>
                <div class="row d-flex align-items-center">
                    <div class="col-md-6">
                        <div class="upload-data py-2">
                            Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
                        </div>
                        <div class="upload-data py-2">
                            Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        @if( isset($data) && $data->image_url_right )
                            <img class="up-img" src="{{ $data->image_url_right  }}">
                        @endif
                    </div>
                </div>
            </small>
        </div>
    </div>
</div>
@php
    $extra = $data->extras??null
@endphp
<div class="col-12">
    <label class="dash-label">Video One</label>
    <div class="form-group row">
        <div class="form-check ml-3">
            <input class="form-check-input video_one_checked" type="radio" name="video_one_status" {{!isset($extra['video_one_status']) && old('video_one_status')==1 ? 'checked' : (isset($extra['video_one_status']) && $extra['video_one_status']==1 ? 'checked' :'') }} value="1" id="video_one_youtube">
            <label class="form-check-label" for="video_one_youtube">
                Youtube
            </label>
        </div>
        <div class="form-check ml-3">
            <input class="form-check-input video_one_checked" type="radio" name="video_one_status" {{!isset($extra['video_one_status']) && old('video_one_status')==0 ? 'checked' : (isset($extra['video_one_status']) && $extra['video_one_status']==0 ? 'checked' :'') }} value="0" id="video_one_upload">
            <label class="form-check-label" for="video_one_upload">
                Upload video
            </label>
        </div>
    </div>

</div>
<div class="col-12 video_one_upload">
    <div class="form-group">
        <label class="dash-label">Video Upload</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="video_one">
            <label class="custom-file-label @error('video_one') is-invalid @enderror" for="customFile"></label>
            @error('video_one')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>

        <div class="row">
            <div class="col-md-12">
                <small>
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="upload-data py-2">
                                Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
                            </div>
                            <div class="upload-data py-2">
                                Allowed Extensions: <kbd>mp4</kbd>,<kbd>mov</kbd>,<kbd>ogg</kbd>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end flex-column align-items-end">
                            @if( isset($data)  && $data->video_one)

                                <video width="240" controls>
                                    <source src="{{ $data->url_video_one?? $data->url_video_one  }}">


                                </video>
                                <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-colume="video_one">Remove Video</span>


                            @endif
                        </div>
                    </div>
                </small>
            </div>

        </div>
    </div>
</div>
<div class="col-12 video_one_youtube">
    <label class="dash-label">Youtube</label>
    <input type="text"  class="form-control @error('video_one_youtube') is-invalid @enderror" value="{{old('video_one_youtube')??$extra['video_one_youtube']??''}}" name="video_one_youtube" placeholder="Youtube " autofocus/>
    @error('video_one_youtube')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror

</div>
<div class="col-12 ">
    <label class="dash-label">Video Two</label>

    <div class="form-group row">
        <div class="form-check ml-3">
            <input class="form-check-input video_two_checked" type="radio" name="video_two_status" {{!isset($extra['video_two_status']) && old('video_two_status')==1 ? 'checked' : (isset($extra['video_two_status']) && $extra['video_two_status']==1 ? 'checked' :'') }} value="1" id="video_two_youtube">
            <label class="form-check-label" for="video_two_youtube">
                Youtube
            </label>
        </div>
        <div class="form-check ml-3">
            <input class="form-check-input video_two_checked" type="radio" name="video_two_status" {{!isset($extra['video_two_status']) && old('video_two_status')==0 ? 'checked' : (isset($extra['video_two_status']) && $extra['video_two_status']==0 ? 'checked' :'') }} value="0" id="video_two_upload">
            <label class="form-check-label" for="video_two_upload">
                Upload video
            </label>
        </div>
    </div>
</div>
<div class="col-12 video_two_upload">
    <div class="form-group">
        <label class="dash-label">Video Upload</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="video_two">
            <label class="custom-file-label @error('video_two') is-invalid @enderror" for="customFile"></label>
            @error('video_two')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>

        <div class="row">
            <div class="col-md-12">
                <small>
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="upload-data py-2">
                                Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
                            </div>
                            <div class="upload-data py-2">
                                Allowed Extensions: <kbd>mp4</kbd>,<kbd>mov</kbd>,<kbd>ogg</kbd>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end flex-column align-items-end">
                            @if( isset($data) && $data->video_two )
                                <video width="240" controls>
                                    <source src="{{ $data->url_video_two?? $data->url_video_two  }}">
                                </video>
                                <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-colume="video_two">Remove Video</span>

                            @endif
                        </div>
                    </div>
                </small>
            </div>

        </div>
    </div>
</div>
<div class="col-12 video_two_youtube">
    <label class="dash-label">Youtube</label>
    <input type="text"  class="form-control @error('video_two_youtube') is-invalid @enderror" value="{{old('video_two_youtube')??$extra['video_two_youtube']??''}}" name="video_two_youtube" placeholder="Youtube " autofocus/>
    @error('video_two_youtube')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror

</div>

<div class="col-12 ">
    <label class="dash-label">Video Three</label>

    <div class="form-group row">
        <div class="form-check ml-3">
            <input class="form-check-input video_three_checked" type="radio" name="video_three_status" {{!isset($extra['video_three_status']) && old('video_three_status')==1 ? 'checked' : (isset($extra['video_three_status']) && $extra['video_three_status']==1 ? 'checked' :'') }} value="1" id="video_three_youtube">
            <label class="form-check-label" for="video_three_youtube">
                Youtube
            </label>
        </div>
        <div class="form-check ml-3">
            <input class="form-check-input video_three_checked" type="radio" name="video_three_status" {{!isset($extra['video_three_status']) && old('video_three_status')==0 ? 'checked' : (isset($extra['video_three_status']) && $extra['video_three_status']==0 ? 'checked' :'') }} value="0" id="video_three_upload">
            <label class="form-check-label" for="video_three_upload">
                Upload video
            </label>
        </div>
    </div>
</div>
<div class="col-12 video_three_upload">
    <div class="form-group">
        <label class="dash-label">Video Upload</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="video_three">
            <label class="custom-file-label @error('video_three') is-invalid @enderror" for="customFile"></label>
            @error('video_three')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>

        <div class="row">
            <div class="col-md-12">
                <small>
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="upload-data py-2">
                                Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
                            </div>
                            <div class="upload-data py-2">
                                Allowed Extensions: <kbd>mp4</kbd>,<kbd>mov</kbd>,<kbd>ogg</kbd>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end flex-column align-items-end">
                            @if( isset($data) && $data->video_three )
                                <video width="240" controls>
                                    <source src="{{ $data->url_video_three?? $data->url_video_three  }}">
                                </video>
                                <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-colume="video_three">Remove Video</span>

                            @endif


                        </div>
                    </div>
                </small>
            </div>
        </div>
    </div>
</div>
<div class="col-12 video_three_youtube">
    <label class="dash-label">Youtube</label>
    <input type="text"  class="form-control @error('video_three_youtube') is-invalid @enderror" value="{{old('video_three_youtube')??$extra['video_three_youtube']??''}}" name="video_three_youtube" placeholder="Youtube " autofocus/>
    @error('video_three_youtube')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

    <script>
        $(function () {

            //start youtube or upload file video one
            if ($('.video_one_checked').is(":checked")) {
                if ($('#video_one_upload').is(":checked")) {
                    $('.video_one_youtube').hide();
                    $('.video_one_upload').show();
                } else {
                    $('.video_one_youtube').show();
                    $('.video_one_upload').hide();
                }
            }

            $(document).on("click", '.video_one_checked', function () {
                if ($('#video_one_upload').is(":checked")) {
                    $('.video_one_youtube').hide();
                    $('.video_one_upload').show();
                } else {
                    $('.video_one_youtube').show();
                    $('.video_one_upload').hide();
                }
            });
            //end youtube or upload file video one
            //start youtube or upload file video two
            if ($('.video_two_checked').is(":checked")) {
                if ($('#video_two_upload').is(":checked")) {
                    $('.video_two_youtube').hide();
                    $('.video_two_upload').show();
                } else {
                    $('.video_two_youtube').show();
                    $('.video_two_upload').hide();
                }
            }

            $(document).on("click", '.video_two_checked', function () {
                if ($('#video_two_upload').is(":checked")) {
                    $('.video_two_youtube').hide();
                    $('.video_two_upload').show();
                } else {
                    $('.video_two_youtube').show();
                    $('.video_two_upload').hide();
                }
            });
            //end youtube or upload file video two
            //start youtube or upload file video three

            if ($('.video_three_checked').is(":checked")) {
                if ($('#video_three_upload').is(":checked")) {
                    $('.video_three_youtube').hide();
                    $('.video_three_upload').show();
                } else {
                    $('.video_three_youtube').show();
                    $('.video_three_upload').hide();
                }
            }

            $(document).on("click", '.video_three_checked', function () {
                if ($('#video_three_upload').is(":checked")) {
                    $('.video_three_youtube').hide();
                    $('.video_three_upload').show();
                } else {
                    $('.video_three_youtube').show();
                    $('.video_three_upload').hide();
                }
            });
            //end youtube or upload file video three
                $('.remove_video').on('click', function () {


                    Swal.fire({
                        html: 'Are your sure you want to delete this video?',
                        showDenyButton: true,
                        confirmButtonText: `Yes`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            // alert();
                            var token = "<?php echo csrf_token() ?>";

                            $.ajax({
                                type: 'POST',
                                url: '{{route(front_route('user.ajax_remove_video'))}}',
                                data: {video: $(this).data('colume'), id: $(this).data('id')},
                                success: function (msg) {
                                    console.log(msg.status);
                                    if (msg.status == true) {
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
            }
        )
    </script>

@endpush
