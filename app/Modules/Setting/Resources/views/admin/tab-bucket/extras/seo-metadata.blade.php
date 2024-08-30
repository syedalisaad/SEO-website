<form action="{{ route('admin.site.save_setting') }}" method="POST">
{{ csrf_field() }}
    <div class="card-body">
        <h4>Search Engine Optimization Information</h4><br/>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Title:</label>
            <div class="col-sm-6">
                <input type="text" name="seometa[meta_title]" class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" value="{{ $data['seometa']['meta_title'] ?? old('meta_title') }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Keywords:</label>
            <div class="col-sm-6">
                <input type="text" name="seometa[meta_keywords]" class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" value="{{ $data['seometa']['meta_keywords'] ?? old('meta_keywords') }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Description:</label>
            <div class="col-sm-6">
                <textarea name="seometa[meta_description]" class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}">{{ $data['seometa']['meta_description'] ?? old('meta_description') }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Google Analytic ID:</label>
            <div class="col-sm-6">
                <input type="text" name="seometa[google_analytic_id]" class="form-control {{ $errors->has('google_analytic_id') ? 'is-invalid' : '' }}" value="{{ $data['seometa']['google_analytic_id'] ?? old('google_analytic_id') }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Site Map URL:</label>
            <div class="col-sm-6">
                <input type="text" name="seometa[site_map_url]" class="form-control {{ $errors->has('site_map_url') ? 'is-invalid' : '' }}" value="{{ $data['seometa']['site_map_url'] ?? old('site_map_url') }}">
            </div>
        </div>
    </div>

    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>
</form>
