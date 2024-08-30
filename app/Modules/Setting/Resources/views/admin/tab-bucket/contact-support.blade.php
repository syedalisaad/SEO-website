<form action="{{ route(admin_route('site.save_setting')) }}" method="POST">
    @csrf
    <div class="card-body">

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h4>Contact Support Information</h4><br/>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Address:</label>
                    <div class="col-sm-6">
                        <textarea name="contact_support[address]" class="form-control @error('contact_support.address') is-invalid @enderror">{{ old('contact_support.address')?:$data['contact_support']['address']??null }}</textarea>
                        @error('contact_support.address')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Google Address:</label>
                    <div class="col-sm-6">
                        <textarea name="contact_support[google_address]" class="form-control @error('contact_support.google_address') is-invalid @enderror">{{ old('contact_support.google_address')?:$data['contact_support']['google_address']??null }}</textarea>
                        @error('contact_support.google_address')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Contact Number:</label>
                    <div class="col-sm-6">
                        <input type="text" name="contact_support[contact_number]" class="form-control @error('contact_support.contact_number') is-invalid @enderror" value="{{ old('contact_support.contact_number')?:$data['contact_support']['contact_number']??null }}">
                        @error('contact_support.contact_number')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Fax Number:</label>
                    <div class="col-sm-6">
                        <input type="text" name="contact_support[fax_number]" class="form-control @error('contact_support.fax_number') is-invalid @enderror" value="{{ old('contact_support.fax_number')?:$data['contact_support']['fax_number']??null }}">
                        @error('contact_support.fax_number')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Contact Email:</label>
                    <div class="col-sm-6">
                        <input type="text" name="contact_support[contact_email]" class="form-control @error('contact_support.contact_email') is-invalid @enderror" value="{{ old('contact_support.contact_email')?:$data['contact_support']['contact_email']??null }}">
                        @error('contact_support.contact_email')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <h4>Search Engine Optimization Information</h4><br/>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Title:</label>
                    <div class="col-sm-6">
                        <input type="text" name="seo_metadata[meta_title]" class="form-control @error('seo_metadata.meta_title') is-invalid @enderror" value="{{ old('seo_metadata.meta_title')?:$data['seo_metadata']['meta_title']??null }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Keywords:</label>
                    <div class="col-sm-6">
                        <textarea name="seo_metadata[meta_keywords]" class="form-control @error('seo_metadata.meta_keywords') is-invalid @enderror">{{ old('seo_metadata.meta_keywords')?:$data['seo_metadata']['meta_keywords']??null }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Description:</label>
                    <div class="col-sm-6">
                        <textarea name="seo_metadata[meta_description]" class="form-control @error('seo_metadata.meta_description') is-invalid @enderror">{{ old('seo_metadata.meta_description')?:$data['seo_metadata']['meta_description']??null }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-yarn">Save</button>
        </div>
    </div>
</form>
