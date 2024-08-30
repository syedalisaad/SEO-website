<div class="row form-group">
    <div class="col-sm-6">
        <label class="cust-label">Firs Name <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="first_name" value="{{ old('first_name',  $data->first_name ?? null) }}" class="form-control form-control-sm @error('first_name') is-invalid @enderror" placeholder="First Name">
            @error('first_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-6">
        <label class="cust-label">Last Name <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="last_name" value="{{ old('last_name', $data->last_name ?? null) }}" class="form-control form-control-sm @error('last_name') is-invalid @enderror" placeholder="Last Name">
            @error('last_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-6">
        <label class="cust-label">Email <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="email" name="email" value="{{ old('email', $data->email ?? null) }}" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email Address">
            @error('email')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-6">
        <label class="cust-label">Password @if(!isset($data) )<strong style="color:#c00">*</strong>@endif</label>
        <div class="input-group">
            <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password')?:null }}"/>
            <div class="input-group-append constPwdAction" style="cursor:pointer;">
                <span class="input-group-text"><i class="fa fa-eye"></i></span>
            </div>
            @error('password')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-6">
        <label class="cust-label">Phone <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" minlength="10" maxlength="10" id="pop_phone" name="phone" value="{{ old('phone', $data->phone ?? null) }}" class="form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Phone Number">
            @error('phone')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>


    <div class="col-sm-6">
        <label class="cust-label">Hospital <strong style="color:#c00">*</strong></label>
        <select name="hospital_id" class="select2 @error('hospital_id') is-invalid @enderror" style="width: 100%;">
            @php $hospitals     = App\Models\Hospital::getLists(); @endphp
            @php $hospital_id   = old('hospital_id', $data->detail->hospital_id ?? null); @endphp
            @if( count($hospitals) )
                @foreach($hospitals as $key => $value )
                    <option {{ $hospital_id == $key ? 'selected' : '' }} value="{{ $key }}"> {{ $value }} </option>
                @endforeach
            @endif
        </select>
        @error('hospital_id')<span class="error invalid-feedback">{{ $message }}</span>@enderror
    </div>


</div>

<div class="row form-group" style="display: none">
    <div class="col-sm-2">
        <div class="form-group">
            <label class="cust-label">Approved <strong style="color:#c00">*</strong></label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_hospital_approved" class="custom-control-input" id="isHospital" checked value="1">
                <label class="custom-control-label" for="isHospital">Visibilty</label>
            </div>
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-6">
        <label class="cust-label">Profile Image </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="source_image">
            <label class="custom-file-label @error('source_image') is-invalid @enderror" for="customFile"></label>
            @error('source_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>
        <small class="text-muted float-left" style="margin-top: 5px;">
            Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
            @if( isset($data) && $data->image_url )
                <a href="{{ $data->image_url  }}" target="_blank" class="float-right ml-5">View Image</a>
            @endif
        </small>
        <small class="text-muted float-left" style="margin-top: 5px;">
            Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
        </small>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label class="cust-label">Activate Account <strong style="color:#c00">*</strong></label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_active" {{ $is_active == 1 ? 'checked' : '' }} class="custom-control-input" id="isActive" value="1">
                <label class="custom-control-label" for="isActive">Active</label>
            </div>
        </div>
    </div>
</div>
