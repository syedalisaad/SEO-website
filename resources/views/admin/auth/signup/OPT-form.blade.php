<div class="mt-4 mb-4 row form-group {{ old('verifytoken') ? 'float' : '' }}">
    <label class="abs-float">Verification Code</label>
    <input type="text" class="form-control form-control-sm text-center @error('verifytoken') is-invalid @enderror" name="verifytoken" value="{{ old('verifytoken') ?: '' }}" />
    @error('verifytoken')
        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
    @enderror
</div>
