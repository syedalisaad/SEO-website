<form class="form-horizontal" method="POST" action="{{ route(admin_route('site.change_password')) }}">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Old Password</label>
            <div class="col-sm-6">
                <input type="password" name="old_password" class="form-control form-control-sm @error('old_password') is-invalid @enderror" placeholder="Old Password" maxlength="20" value="{{ old('old_password') }}">
                @error('old_password')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">New Password</label>
            <div class="col-sm-6">
                <input type="password" name="new_password" class="form-control form-control-sm @error('new_password') is-invalid @enderror" placeholder="New Password" maxlength="20" value="{{ old('new_password') }}">
                @error('new_password')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Repeat New Password</label>
            <div class="col-sm-6">
                <input type="password" name="repeat_password" class="form-control form-control-sm @error('repeat_password') is-invalid @enderror" placeholder="Repeat New Password" maxlength="20" value="{{ old('repeat_password') }}">
                @error('repeat_password')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-yarn">Change Password</button>
                <button type="reset" class="btn btn-default">Clear</button>
            </div>
        </div>
    </div>
</form>
