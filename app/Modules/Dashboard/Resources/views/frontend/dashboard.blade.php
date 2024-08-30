@extends( front_layout('master') )
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard">

        <div class="dash-side">
            @include( frontend_module_view('partials.sidebar') )
        </div>

        <div class="dash-data">
            <div class="loginpage">
                <div class="dash-detial">
                    @if($order)
                        <form role="form" class="dash-upload" action="{{route(front_route('user.dashboard_update'))}}" method="POST" enctype="multipart/form-data">
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="page-title">
                                        Dashboard
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-2">
                                    @if(!isset($data))
                                        <input type="hidden" name="new_user" value="1">

                                    @endif
                                    @if(isset($order) && isset($data) && $data->is_approved == 1)
                                        {{-- Send email once published & any update done by user --}}
                                        <h4>Publish</h4>
                                        <label class="switch publish-switch">
                                            <input type="checkbox" name="is_publish" value="1" {{$data->is_publish==1? 'checked':''}}>
                                            <span type="checkbox" value="1" class="slider round"></span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if($order)
                                        <div class="dashboard_hospital_settings">


                                            @include( frontend_module_view('partials.simple-messages') )

                                            @csrf

                                            <input name="hospital_id" type="hidden" value="{{$user_hospital_details->HospitalDetail->id}}">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="dash-label">Hospital Name <span style="color: red">*</span></label>
                                                        <input type="text" value="{{$data->name??$user_hospital_details->HospitalDetail->facility_name}}" class="form-control @error('hospital_name') is-invalid @enderror" value="{{old('hospital_name')??$data->hospital_name??''}}" name="hospital_name" placeholder="{{ __('Hospital Name') }}" autofocus/>
                                                        @error('hospital_name')
                                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="dash-label">Phone Number <span style="color: red">*</span></label>
                                                        <input type="text" value="{{$data->phone_number??$user_hospital_details->HospitalDetail->phone_number}}" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')??$data->phone??''}}" name="phone" placeholder="{{ __('Phone number') }}" autofocus/>
                                                        @error('phone')
                                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="dash-label">Website URL <span style="color: red">*</span></label>
                                                        <input type="text" class="form-control @error('ref_url') is-invalid @enderror" value="{{old('ref_url')??$data->ref_url??''}}" name="ref_url" placeholder="{{ __('Hospital Website URL') }}" autofocus/>
                                                        @error('ref_url')
                                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="dash-label">Logo Image <span style="color: red">*</span></label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile" name="logo_image">
                                                            <label class="custom-file-label @error('logo_image') is-invalid @enderror" for="customFile"></label>
                                                            @error('logo_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
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
                                                                                Minimum Upload Size: <kbd>width:300px height:300px</kbd>

                                                                            </div>
                                                                            <div class="upload-data py-2">
                                                                                Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            @if( isset($data) && $data->logo_image )
                                                                                <img class="up-img" src="{{ $data->image_url_logo  }}">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="dash-label">Share Image </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="file-input" name="share_image_crop">
                                                                    <label class="custom-file-label @error('share_image') is-invalid @enderror" for="customFile"></label>
                                                                    @error('share_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">

                                                                <div class="cropBox">
                                                                    <div class="croppingArea">
                                                                        <div class="box-2 realImg">
                                                                            <div class="result"></div>
                                                                        </div>

                                                                        @php
                                                                           $image_url_share = '';

                                                                           if( isset($data) && $data->share_image ){
                                                                               $image_url_share = $data->image_url_share;
                                                                           }
                                                                       @endphp
                                                                        <div class="box-2 img-result hide cropImg" style="display:{{ $image_url_share ? 'block' : 'none' }}">
                                                                            <img class="cropped" src="{{ $image_url_share }}" alt="">
                                                                        </div>
                                                                    </div>


                                                                    <div class="box cropBtn">
                                                                        <div class="options hide">
                                                                            <input type="hidden" class="img-w" placeholder="Image Width" value="300" />
                                                                        </div>
                                                                        <!-- save btn -->
                                                                        <button class="btn save hide" style="display: none;">Crop Image</button>
                                                                        <!-- download btn -->
                                                                        <a href="javascript:void(0)" class="btn download hide">Upload Image</a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="dash-label">Main Image <span style="color: red">*</span></label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="customFile" name="right_image">
                                                            <label class="custom-file-label @error('right_image') is-invalid @enderror" for="customFile"></label>
                                                            @error('right_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
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
                                                                                Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 d-flex justify-content-end">
                                                                            @if( isset($data) && $data->right_image )
                                                                                <img class="up-img" src="{{ $data->image_url_right  }}">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                 $video = $order->hasOneOrderItem->product->extras;
                                                 $extra = $data->extras??null
                                                @endphp
                                                @if(isset($video['video']) && $video['video'])
                                                    @if($video['video']>=1)

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
                                                                <label class="dash-label">Upload Video</label>
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

                                                                                        <video width="400" class="video_frame" controls>
                                                                                            <source src="{{ $data->url_video_one?? $data->url_video_one  }}">

                                                                                        </video>
                                                                                        <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-column="video_one">Remove Video</span>

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
                                                    @endif
                                                    @if($video['video']>=2)
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
                                                                <label class="dash-label">Upload Video</label>
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
                                                                                        <video width="400" class="video_frame" controls>
                                                                                            <source src="{{ $data->url_video_two?? $data->url_video_two  }}">
                                                                                        </video>
                                                                                        <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-column="video_two">Remove Video</span>

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
                                                    @endif
                                                    @if($video['video']>=3)
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
                                                                <label class="dash-label">Upload Video</label>
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
                                                                                        <video class="video_frame" width="400" controls>
                                                                                            <source src="{{ $data->url_video_three?? $data->url_video_three  }}">
                                                                                        </video>
                                                                                        <span class="mt-2 btn btn-danger remove_video" data-id="{{$data->id}}" data-column="video_three">Remove Video</span>
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
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="button">
                                                        <button type="submit">{{ __('Submit For Verification') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <div class="buy-pckge">
                                            <ul>
                                                <li><strong>Hospital name:</strong> {{$data->name??$user_hospital_details->HospitalDetail->facility_name}}</li>
                                                <li><strong>Phone no:</strong> {{$data->phone_number??$user_hospital_details->HospitalDetail->phone_number}}</li>
                                            </ul>
                                            <p>Please select the package, so you can update the hospital details according to selected package.</p>
                                            <a class="buy-btn" href="{{route(front_route('user.packages'))}}">View Packages</a>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </form>
                </div>

            </div>

        </div>
    </div>
    </div>
    </div>

@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<style>
    .page { margin: 1em auto; max-width: 768px; display: flex; align-items: flex-start; flex-wrap: wrap; height: 100%; }
    /*.box { padding: 0.5em; width: 100%; margin: 0.5em; }*/
    /*.box-2 { padding: 0.5em; width: calc(100%/2 - 1em); }*/
    .options label, .options input { width: 4em; padding: 0.5em 1em; }
    .btn {
        background: white; color: black; border: 1px solid black; padding: 0.5em 1em; text-decoration: none; margin: 0.8em 0.3em; display: inline-block; cursor: pointer;
    }
    .hide { display: none; }
    .hide img { max-width: 100%; }




    .cropBox {
        box-shadow: 0 0 10px rgb(0 0 0 / 10%);
        padding: 45px 30px;
        margin: 20px 0px 10px;
        border-radius: 0px 0px 10px 10px;
        display: flex;
        border-top: 10px solid #2952A2;
        justify-content: space-between;
        gap: 30px;
    }
    .cropBox .croppingArea {
        display: flex;
        gap: 20px;
    }
    .cropBtn {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    .cropBtn .save {
        margin: 0 0 10px;
    }
    .cropBtn .save:hover {
        color: #fff;
    }
    .cropBtn .download {
        margin: 0;
        min-width: 177px;
        padding: 14px 10px;
    }
</style>
@endpush
@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        let result = document.querySelector('.result'),
            img_result = document.querySelector('.img-result'),
            img_w = document.querySelector('.img-w'),
            img_h = document.querySelector('.img-h'),
            options = document.querySelector('.options'),
            save = document.querySelector('.save'),
            cropped = document.querySelector('.cropped'),
            dwn = document.querySelector('.download'),
            upload = document.querySelector('#file-input'),
            cropper = '';

        let cropBox = $('.cropBox');
        @if( !(isset($data) && $data->share_image) )
        cropBox.hide();
        @endif

        // on change show image with crop options
        upload.addEventListener('change', e => {

            if (e.target.files.length)
            {
                save.style.display = 'block';
                cropBox.show();
                $('.box-2, .box').show();

                // start file reader
                const reader = new FileReader();
                reader.onload = e => {
                    if (e.target.result)
                    {
                        // create new image
                        let img = document.createElement('img');
                        img.id = 'image';
                        img.src = e.target.result;
                        console.log('img.src', img.src);
                        // clean result before
                        result.innerHTML = '';
                        // append new image
                        result.appendChild(img);
                        // show save btn and options
                        save.classList.remove('hide');
                        options.classList.remove('hide');
                        // init cropper
                        cropper = new Cropper(img);
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // save on click
        save.addEventListener('click', e => {
            e.preventDefault();
            // get result to data uri
            let imgSrc = cropper.getCroppedCanvas({
                width: img_w.value // input value
            }).toDataURL();
            // remove hide class of img
            cropped.classList.remove('hide');
            img_result.classList.remove('hide');
            // show image cropped
            cropped.src = imgSrc;
            dwn.classList.remove('hide');
            dwn.download = 'imagename.png';
            dwn.setAttribute('data-href', imgSrc);
        });

        $(document).on('click', '.download', function(){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            let serializedData = {
                hospital_id: '{{ $user_hospital_details->hospital_id }}',
                user_id: '{{ $user_hospital_details->user_id }}',
                share_image64: $(this).data('href'),
                _token: CSRF_TOKEN
            };

            console.log('base64', serializedData );

            let route_share_upload = "{{ route(front_route('user.dashboard.share_image.upload')) }}";

            $.ajax({
                url: route_share_upload,
                type: 'POST',
                data: serializedData,
                dataType: 'JSON',
                success: function ( response ) {

                    if( response.success )
                    {
                       $('.box-2, .box').hide();
                       $('.img-result, .cropped').show();
                       $('.cropped').attr('src', response.image_source);
                        //upload.val('');
                        upload.value = '';
                    }
                    console.log('response', response);
                }
            });
        });

    </script>
    <script>

        $(document).ready(function () {

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


            $('input[name="is_publish"]').on('change', function () {
                $('form.dash-upload').submit()

            });

            $('.remove_video').on('click', function () {
                if ($(this).data('column') !== null && $(this).data('id') !== null) {
                    Swal.fire({
                        html: 'Are your sure you want to delete this video?',
                        showDenyButton: true,
                        confirmButtonText: `Yes`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '{{route(front_route('user.ajax_remove_video'))}}',
                                data: {
                                    video: $(this).data('column'),
                                    id: $(this).data('id')
                                },
                                success: function (msg) {
                                    if (msg.status == true) {
                                        // $(this).closest('div').css("display",'none!important')
                                        Swal.fire('deleted!', '', 'success');
                                        location.reload();
                                    } else {
                                        Swal.fire('', msg.message, 'error');
                                    }
                                }
                            });

                        } else if (result.isDenied) {
                            Swal.fire('', 'Changes are not saved', 'info')
                        }
                    });
                }
            });

        })

        $(document).on('keypress', 'input[type="number"]', function (event) {
            if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
                event.preventDefault(); //stop character from entering input
            }
        });


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d778189688.js"></script>
@endpush
