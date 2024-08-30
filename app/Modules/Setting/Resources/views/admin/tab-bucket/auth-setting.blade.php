@php $user = getAuth(); @endphp
<form class="form-horizontal" method="POST" action="{{ route(admin_route('site.authsetting')) }}">
    {{ csrf_field() }}
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" name="first_name" class="form-control form-control-sm @error('first_name') is-invalid @enderror" placeholder="First Name" maxlength="30" value="{{ old('first_name')?:$user->first_name??null }}">
                @error('first_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" name="last_name" class="form-control form-control-sm @error('last_name') is-invalid @enderror" placeholder="Last Name" maxlength="30" value="{{ old('last_name')?:$user->last_name??null }}">
                @error('last_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email Address</label>
            <div class="col-sm-6">
                <input type="text" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email')?:$user->email??null }}">
                @error('email')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-yarn">Save Setting</button>
                <button type="reset" class="btn btn-default">Clear</button>
            </div>
        </div>
    </div>
</form>
