@php use \App\Models\Setting; @endphp
<form action="{{ route(admin_route('site.save_setting')) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    @php $site = $data['sites']??null; @endphp
    <div class="card-body">
        <h4>General Setting</h4><br/>
        <div class="form-group row">
            <label for="site_logo" class="col-sm-2 col-form-label">Logo:</label>
            <div class="col-sm-10">
                <input type="file" name="sites[site_logo]" id="site_logo" class="form-control-file">
                <small class="text-muted" style="margin-top: 5px;">Allowed Dimension: <kbd>270px</kbd> by <kbd>60px</kbd></small>
                <br/><small class="text-muted" style="margin-top: 5px;">Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd></small>
                @error('site_logo')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                @if( isset($site['site_logo']) && $site['site_logo'] && is_exists_file(  Setting::$storage_disk . '/'. $site['site_logo'])  )
                    <input type="hidden" name="sites[h_site_logo]" value="{{ $site['site_logo'] ?? null }}">
                    <br/><br/><img src="{{ Setting::getImageUrl($site['site_logo']) }}" class="img-fluid" width="100">
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="site_favicon" class="col-sm-2 col-form-label">Fav Ico:</label>
            <div class="col-sm-10">
                <input type="file" name="sites[site_favicon]" id="site_favicon" class="form-control-file">
                <small class="text-muted" style="margin-top: 5px;">Allowed Extensions: <kbd>ico</kbd></small>
                @error('site_favicon')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                @if( isset($site['site_favicon']) && $site['site_favicon'] && is_exists_file(  Setting::$storage_disk . '/'. $site['site_favicon'])  )
                    <input type="hidden" name="sites[h_site_favicon]" value="{{ $site['site_favicon'] ?? null }}">
                    <br/><img src="{{ Setting::getImageUrl($site['site_favicon']) }}" class="img-fluid" width="30">
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="site_logo_footer" class="col-sm-2 col-form-label">Footer Logo:</label>
            <div class="col-sm-10">
                <input type="file" name="sites[site_logo_footer]" id="site_logo_footer" class="form-control-file">
                <small class="text-muted" style="margin-top: 5px;">Allowed Dimension: <kbd>270px</kbd> by <kbd>60px</kbd></small>
                <br/><small class="text-muted" style="margin-top: 5px;">Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd></small>
                @error('site_logo_footer')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                @if( isset($site['site_logo_footer']) && $site['site_logo_footer'] && is_exists_file(  Setting::$storage_disk . '/'. $site['site_logo_footer'])  )
                    <input type="hidden" name="sites[h_site_logo_footer]" value="{{ $site['site_logo_footer'] ?? null }}">
                    <br/><br/><img src="{{ Setting::getImageUrl($site['site_logo_footer']) }}" class="img-fluid" width="100">
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="site_logo_footer" class="col-sm-2 col-form-label">Share Logo:</label>
            <div class="col-sm-10">
                <input type="file" name="sites[share_logo]" id="share_logo" class="form-control-file">
                <small class="text-muted" style="margin-top: 5px;">Allowed Dimension: <kbd>180px</kbd> by <kbd>180px</kbd></small>
                <br/><small class="text-muted" style="margin-top: 5px;">Allowed Extensions: <kbd>webp</kbd>,<kbd>jpg</kbd>,<kbd>jpeg</kbd>,<kbd>png</kbd></small>
                @error('share_logo')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                @if( isset($site['share_logo']) && $site['share_logo'] && is_exists_file(  Setting::$storage_disk . '/'. $site['share_logo'])  )
                    <input type="hidden" name="sites[h_share_logo]" value="{{ $site['share_logo'] ?? null }}">
                    <br/><br/><img src="{{ Setting::getImageUrl($site['share_logo']) }}" class="img-fluid" width="100">
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Site Name:</label>
            <div class="col-sm-5">
                <input type="text" name="sites[site_name]" class="form-control @error('sites.site_name') is-invalid @enderror" value="{{ $site['site_name'] ?? old('site_name') }}"/>
                @error('sites.site_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email Info:</label>
            <div class="col-sm-5">
                <input type="text" name="sites[email_info]" class="form-control @error('sites.email_info') is-invalid @enderror" value="{{ $site['email_info'] ?? old('sites.email_info') }}"/>
                @error('sites.email_info')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email Support:</label>
            <div class="col-sm-5">
                <input type="text" name="sites[email_support]" class="form-control @error('sites.email_support') is-invalid @enderror" value="{{ $site['email_support'] ?? old('email_support') }}"/>
                @error('sites.email_support')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email Opperations:</label>
            <div class="col-sm-5">
                <input type="text" name="sites[email_opperations]" class="form-control @error('sites.email_opperations') is-invalid @enderror" value="{{ $site['email_opperations'] ?? old('email_opperations') }}"/>
                @error('sites.email_support')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Email (No-reply):</label>
            <div class="col-sm-5">
                <input type="text" name="sites[email_no_reply]" class="form-control @error('sites.email_no_reply') is-invalid @enderror" value="{{ $site['email_no_reply'] ?? old('email_no_reply') }}"/>
                @error('sites.email_no_reply')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Footer Company:</label>
            <div class="col-sm-5">
                <textarea name="sites[footer_about]" class="form-control texteditor @error('sites.footer_about') is-invalid @enderror">{{ $site['footer_about'] ?? old('footer_about') }}</textarea>
                @error('sites.footer_about')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Footer Copyright:</label>
            <div class="col-sm-5">
                <textarea name="sites[footer_text]" class="form-control @error('sites.footer_text') is-invalid @enderror">{{ $site['footer_text'] ?? old('footer_text') }}</textarea>
                @error('sites.footer_text')<span class="error invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-yarn">Save</button>
        </div>
    </div>
</form>

@push('css')
    <link rel="stylesheet" href="{{ admin_asset('/plugins/summernote/summernote-bs4.css') }}"/>
@endpush
@push('scripts')
    <!-- Summernote -->
    <script src="{{ admin_asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>

        $('.texteditor').summernote({
            width: '100%',
            height: 200,
            placeholder: 'Write message here...',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });

    </script>
@endpush
