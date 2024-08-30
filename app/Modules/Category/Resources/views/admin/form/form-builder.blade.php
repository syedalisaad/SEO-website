@php
$categories     = \App\Models\Category::getParentCategories();
$parent_id      = old('parent_id')?:$data->parent_id??0;
@endphp

<div class="row form-group">
    <div class="col-sm-8">
        <label class="cust-label">Name <strong style="color:#c00">*</strong></label>
        <input type="text" name="name" value="{{ old('name')?:$data->name??null }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Name">
        @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
    </div>
    <div class="col-sm-4">
        <label class="cust-label">Parent <strong style="color:#c00">*</strong></label>
        <div class="input-group">
            <select class="form-control select2" name="parent_id">
                <option value="">Select Parent</option>
                @if( count($categories) )
                    @foreach( $categories as $key => $value)
                        <option {{ $parent_id == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                @endif
            </select>
            @error('parent_id')<span class="error invalid-feedback display-block">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Short Description</label>
        <div class="input-group">
            <textarea name="short_desc" rows="5" class="texteditor form-control @error('short_desc') is-invalid @enderror" placeholder="Short Description">{{ old('short_desc') ?? $data->short_desc ?? null }}</textarea>
            @error('short_desc')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <label class="cust-label">Image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="source_image">
            <label class="custom-file-label @error('source_image') is-invalid @enderror" for="customFile"></label>
            @error('source_image')<span class="error invalid-feedback mt-3">{{ $message }}</span>@enderror
        </div>
        <small class="text-muted row ml-1" style="margin-top: 5px;">
            Maximum Upload Size: <kbd>{{ env('IMG_DISPLAY_SIZE', '5MB') }}</kbd>
            @if( isset($data) && $data->source_image )
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
<br/>
