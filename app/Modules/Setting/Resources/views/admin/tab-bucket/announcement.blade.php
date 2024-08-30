@php use \App\Models\Setting; @endphp
<form action="{{ route(admin_route('site.save_setting')) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}

    @php $announcement = $data['announcements']??null; @endphp
    <div class="card-body">
        <h4>Announcement</h4><br/>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Announcement Text:</label>
                    <div class="col-sm-8">
                        <textarea name="announcements[announcement_text]" class="form-control texteditor @error('announcements.announcement_text') is-invalid @enderror">{{ $announcement['announcement_text'] ?? old('announcement_text') }}</textarea>
                        @error('announcements.announcement_text')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Start Date:</label>
                    <div class="col-sm-8">
                        <input type="date" required   name="announcements[start_date]" value="{{ $announcement['start_date'] ?? (old('start_date') ?? date("Y-m-d")) }}" class="form-control start_date @error('start_date') is-invalid @enderror">
                        @error('start_date')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Allow End Date:</label>
                    <div class="col-sm-8">
                        <input type="checkbox" id="end_date" name="announcements[end_date_status]" value="1" {{ isset($announcement['end_date_status']) && $announcement['end_date_status']==1 ? 'checked' :  (old('end_date_status') && old('end_date_status')==1 ? 'checked':'') }} class=" form-check-input  @error('announcements.end_date_status') is-invalid @enderror">
                        @error('announcements.end_date_status')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">End Date:</label>
                    <div class="col-sm-8">
                        <input type="date" required disabled name="announcements[end_date]" value="{{ $announcement['end_date'] ?? old('end_date') }}" class="form-control end_date @error('end_date') is-invalid @enderror">
                        @error('end_date')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Active:</label>
                    <div class="col-sm-8">
                        <input type="checkbox" name="announcements[status]" value="1" {{ isset($announcement['status']) && $announcement['status']==1 ? 'checked' :  (old('status') && old('status')==1 ? 'checked':'') }} class=" form-check-input  @error('announcements.status') is-invalid @enderror">
                        @error('announcements.status')<span class="error invalid-feedback">{{ $message }}</span>@enderror
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

        $(document).ready(function () {

            if ($('#end_date').is(':checked')) {
                $('.end_date').prop('disabled', false)
            } else {
                $('.end_date').prop('disabled', true)
            }

            $('#end_date').on('change', function () {
                if ($('#end_date').is(':checked')) {
                    $('.end_date').prop('disabled', false)
                } else {
                    $('.end_date').prop('disabled', true)
                }
            })
            $("#end_date").rules('add', { greaterThan: "#start_date" });

        })

    </script>
@endpush
