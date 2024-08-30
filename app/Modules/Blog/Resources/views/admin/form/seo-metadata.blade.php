<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Title</label>
        <div class="input-group">
            <input type="text" name="seo_metadata[meta_title]" class="form-control form-control-sm @error('seo_metadata.meta_title') is-invalid @enderror" value="{{ $data->seo_metadata['meta_title'] ?? old('seo_metadata.meta_title') }}" placeholder="Meta Title" />
            @error('seo_metadata.meta_title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Keywords</label>
        <div class="input-group">
            <textarea name="seo_metadata[meta_keywords]" class="form-control form-control-sm @error('seo_metadata.meta_keywords') is-invalid @enderror" placeholder="Meta Keywords">{{ $data->seo_metadata['meta_keywords'] ?? old('seo_metadata.meta_keywords') }}</textarea>
            @error('seo_metadata.meta_keywords')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Meta Description</label>
        <div class="input-group">
            <textarea name="seo_metadata[meta_description]" class="form-control form-control-sm @error('seo_metadata.meta_description') is-invalid @enderror" placeholder="Meta Description">{{ $data->seo_metadata['meta_description'] ?? old('seo_metadata.meta_description') }}</textarea>
            @error('seo_metadata.meta_description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
