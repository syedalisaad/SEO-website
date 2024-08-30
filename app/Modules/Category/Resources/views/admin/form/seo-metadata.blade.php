<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Title</label>
        <div class="input-group">
            <input type="text" name="seo_metadata[meta_title]" class="form-control form-control-sm {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" value="{{ $data->seo_metadata['meta_title'] ?? old('meta_title') }}" placeholder="Meta Title" />
            @error('meta_title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Keyword</label>
        <div class="input-group">
            <input type="text" name="seo_metadata[meta_keywords]" class="form-control form-control-sm {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" value="{{ $data->seo_metadata['meta_keywords'] ?? old('meta_keywords') }}" placeholder="Meta Keywords">
            @error('meta_keywords')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Description</label>
        <div class="input-group">
            <textarea name="seo_metadata[meta_description]" class="form-control form-control-sm {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" placeholder="Meta Description">{{ $data->seo_metadata['meta_description'] ?? old('meta_description') }}</textarea>
            @error('meta_description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
