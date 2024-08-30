<form action="{{ route(admin_route('site.save_setting')) }}" method="POST">
{{ csrf_field() }}
    <div class="card-body">
        <h4>Developer Information</h4><br/>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Version Code:</label>
            <div class="col-sm-5">
                <input type="text" name="developers[version]" class="form-control {{ $errors->has('version') ? 'is-invalid' : '' }}"
                        value="{{ $data['developers']['version'] ?? old('version') }}" />
                @if ($errors->has('version'))
                    <div class="invalid-version">
                        {{ $errors->first('version') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-yarn">Save</button>
        </div>
    </div>
</form>
