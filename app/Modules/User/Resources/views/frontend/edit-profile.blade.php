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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title">
                                Setting
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard_edit_profile">
                                @include( admin_module_view('partials.simple-messages') )

                                <form role="form" class="dash-upload" action="{{route(front_route('user.edit.setting.update'))}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="dash-label">First Name</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{old('first_name')??$data->first_name??''}}" name="first_name" placeholder="{{ __('First Name') }}" autofocus/>
                                        @error('first_name')
                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="dash-label">Last Name</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name')??$data->last_name??''}}" placeholder="{{ __('Last Name') }}" autofocus/>
                                        @error('last_name')
                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="dash-label">Phone Number</label>
                                        <input type="tel" minlength="10" maxlength="10" id="phone" name="phone" value="{{old('phone')??$data->phone??''}}" placeholder="000-000-0000" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')??$exists_session['phone']??'' }}"/>
                                        @error('phone')
                                        <span class="error invalid-feedback" style="display: block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="dash-label">Profile Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="source_image">
                                            <label class="custom-file-label @error('source_image') is-invalid @enderror" for="customFile"></label>
                                            @error('source_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
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
                                                            @if( isset($data) && $data->image_url )
                                                                <img class="up-img" src="{{ $data->image_url  }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button">
                                        <button type="submit">{{ __('Save') }}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $('#phone').on('change', function () {
            var phoneNumberString = $(this).val();
            phoneNumberString = formatPhoneNumber(phoneNumberString);
            $(this).val(phoneNumberString);


        });

        function formatPhoneNumber(phoneNumberString) {
            var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return null;
        }

    </script>
@endpush
