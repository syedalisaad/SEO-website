@php use \App\Models\Page; @endphp
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Name</label>
        <div class="input-group">
            <input type="text" name="name" value="{{ old('name', $data->name ?? null) }}" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Name">
            @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <label class="cust-label">Description</label>
        <div class="input-group">
            <textarea name="description" class="texteditor form-control @error('description') is-invalid @enderror" placeholder="Short Description">{{ old('description', $data->description ?? null) }}</textarea>
            @error('description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
