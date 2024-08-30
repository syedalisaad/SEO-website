<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Name <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <input type="text" name="name" value="{{ old('name') ?? $data->name ?? null }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Name">
            @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Short Description <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <textarea maxlength="255" name="short_desc" rows="3" class="form-control @error('short_desc') is-invalid @enderror" placeholder="Short Description">{{ old('short_desc') ?? $data->short_desc ?? null }}</textarea>
            @error('short_desc')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Description <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <textarea name="description" class="texteditor form-control @error('description') is-invalid @enderror" placeholder="Short Description">{{ old('description') ?? $data->description ?? null }}</textarea>
            @error('description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="row form-group">
    <div class="col-sm-8">
        <label class="cust-label">Post Image @if(!isset($data) )<strong style="color:#c00">*</strong>@endif</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="source_image">
            <label class="custom-file-label @error('source_image') is-invalid @enderror" for="customFile"></label>
            @error('source_image')<span class="error invalid-feedback mt-3 ">{{ $message }}</span>@enderror
        </div>
        <small class="text-muted row ml-1" style="margin-top: 5px;">
            Maximum Upload Size: <kbd>{{ env('IMG_DISPLAY_SIZE', '5MB') }}</kbd>
            @if( isset($data) && $data->image_url )
                <a href="{{ $data->image_url  }}" target="_blank" class="float-right ml-5">View Image</a>
            @endif
        </small>
        <small class="text-muted row ml-1" style="margin-top: 5px;">
            Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd>,<kbd>gif</kbd>
        </small>
    </div>
    <div class="col-sm-4">
        <label class="cust-label">Visibilty <strong style="color:#c00">*</strong></label>
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_active" {{ $is_active == 1 ? 'checked' : '' }} class="custom-control-input" id="isActive" value="1">
                <label class="custom-control-label" for="isActive">Active</label>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ admin_asset('/plugins/summernote/summernote-bs4.css') }}" />
@endpush
@push('scripts')
<script src="{{ admin_asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $('.texteditor').summernote({
        width: '100%',
        height: 200,
        placeholder: 'Write Post detail here...',
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['insert', ['link']],
            ['lineHeights', ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0']],
            ['height', ['height']],
        ],
    });
</script>
@endpush
