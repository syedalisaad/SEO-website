@php use \App\Models\Setting; @endphp
<form action="{{ route(admin_route('site.save_setting')) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @php
        $frontend_support = $data['frontend_support'] ?? null;
        $frontend_video_box_1 = $frontend_support['frontend_video_box_1'] ?? null;
        $frontend_video_box_2 = $frontend_support['frontend_video_box_2'] ?? null;
    @endphp
    <div class="card-body">
        <h4>Frontend Support</h4><br/>

        <div class="row">

            <div class="col-md-6 col-sm-12">
                <div class="p-2" style="border:1px solid #a1a1a1">
                    <h5>Container Video 1</h5><br/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title:</label>
                        <div class="col-sm-8">
                            <textarea name="frontend_support[frontend_video_box_1][title]" rows="3" class="form-control @error('frontend_support.frontend_video_box_1.title') is-invalid @enderror">{{ old('frontend_support.frontend_video_box_1.title')?:$frontend_video_box_1['title']??null }}</textarea>
                            @error('frontend_support.frontend_video_box_1.title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Description:</label>
                        <div class="col-sm-8">
                            <textarea name="frontend_support[frontend_video_box_1][description]" rows="3" class="form-control @error('frontend_support.frontend_video_box_1.description') is-invalid @enderror">{{ old('frontend_support.frontend_video_box_1.description')?:$frontend_video_box_1['description']??null }}</textarea>
                            @error('frontend_support.frontend_video_box_1.description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="video_source_2" class="col-sm-3 col-form-label">Video:</label>


                        <div class="form-check"> &nbsp;
                            <input class="form-check-input " type="radio" name="frontend_support[frontend_video_box_1][video_upload_status]" {{!isset($frontend_video_box_1['video_upload_status']) && old('frontend_support.frontend_video_box_1.video_upload_status')==1 ? 'checked' : (isset($frontend_video_box_1['video_upload_status']) && $frontend_video_box_1['video_upload_status']==1 ? 'checked' :'') }} value="1"   id="frontend_video_box_1_youtube">
                            <label class="form-check-label" for="frontend_video_box_1_youtube">
                                Youtube &nbsp;
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input  " type="radio" name="frontend_support[frontend_video_box_1][video_upload_status]" {{!isset($frontend_video_box_1['video_upload_status']) && old('frontend_support.frontend_video_box_1.video_upload_status')==0 ? 'checked' : (isset($frontend_video_box_1['video_upload_status']) && $frontend_video_box_1['video_upload_status']==0 ? 'checked' :'') }} value="0" id="frontend_video_box_1_upload" >
                            <label class="form-check-label" for="frontend_video_box_1_upload">
                                Upload video
                            </label>
                        </div>
                        @error('frontend_support.frontend_video_box_1.video_upload_status')<span class="error invalid-feedback">{{ $message }}</span>@enderror

                    </div>
                    <div class="form-group row frontend_video_box_1_youtube">

                        <label for="video_source_2" class="col-sm-3 col-form-label">Youtube:</label>
                        <div class="col-sm-8">
                            <input type="text" name="frontend_support[frontend_video_box_1][youtube]" class="form-control @error('frontend_support.frontend_video_box_1.youtube') is-invalid @enderror" value="{{ old('frontend_support.frontend_video_box_1.youtube')?:$frontend_video_box_1['youtube']??null }}">
                            @error('frontend_support.frontend_video_box_1.youtubee')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row frontend_video_box_1_upload">

                        <label for="video_source_2" class="col-sm-3 col-form-label">Video Upload:</label>
                        <div class="col-sm-8">
                            <div class="col-sm-10">
                                <input type="file" name="frontend_support[frontend_video_box_1][video_upload]" id="video_upload_1" class="form-control-file">
                                <small class="text-muted" style="margin-top: 5px;">Allowed Dimension: <kbd>270px</kbd> by <kbd>60px</kbd></small>
                                <br/>
                                <small class="text-muted" style="margin-top: 5px;"> Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>,
                                    Allowed Extensions: <kbd>mp4</kbd>,<kbd>mov</kbd>,<kbd>ogg</kbd>
                                </small>
                                @error('frontend_support.frontend_video_box_2.video_upload')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                @if( isset($frontend_video_box_1['video_upload']) && $frontend_video_box_1['video_upload'] && is_exists_file(  Setting::$storage_disk . '/'. $frontend_video_box_1['video_upload'])  )
                                    <div id="frame_video_remove_1">
                                    <input type="hidden" name="frontend_support[frontend_video_box_1][h_video_upload]" value="{{ $frontend_video_box_1['video_upload'] ?? null }}">
                                    <br/><br/>
                                    <video width="300" class="video_frame" controls>
                                        <source src="{{ Setting::getImageUrl($frontend_video_box_1['video_upload']) }}">
                                    </video>
                                    <span id="video_remove_1" class="btn btn-danger">Remove</span>
                                    <input type="hidden" class="video_remove_1"  name="frontend_support[frontend_video_box_1][remove_video]" value="0">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="p-2" style="border:1px solid #a1a1a1">
                    <h5>Container Video 2</h5><br/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title:</label>
                        <div class="col-sm-8">
                            <textarea name="frontend_support[frontend_video_box_2][title]" rows="3" class="form-control @error('frontend_support.frontend_video_box_1.title') is-invalid @enderror">{{ old('frontend_support.frontend_video_box_2.title')?:$frontend_video_box_2['title']??null }}</textarea>
                            @error('frontend_support.frontend_video_box_2.title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Description:</label>
                        <div class="col-sm-8">
                            <textarea name="frontend_support[frontend_video_box_2][description]" rows="3" class="form-control @error('frontend_support.frontend_video_box_1.description') is-invalid @enderror">{{ old('frontend_support.frontend_video_box_2.description')?:$frontend_video_box_2['description']??null }}</textarea>
                            @error('frontend_support.frontend_video_box_2.description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="video_source_2" class="col-sm-3 col-form-label">Video:</label>


                        <div class="form-check"> &nbsp;
                            <input class="form-check-input " type="radio" name="frontend_support[frontend_video_box_2][video_upload_status]" {{!isset($frontend_video_box_2['video_upload_status']) && old('frontend_support.frontend_video_box_2.video_upload_status')==1 ? 'checked' : (isset($frontend_video_box_2['video_upload_status']) && $frontend_video_box_2['video_upload_status']==1 ? 'checked' :'') }} value="1"   id="frontend_video_box_2_youtube">
                            <label class="form-check-label" for="frontend_video_box_2_youtube">
                                Youtube &nbsp;
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input  " type="radio" name="frontend_support[frontend_video_box_2][video_upload_status]" {{!isset($frontend_video_box_2['video_upload_status']) && old('frontend_support.frontend_video_box_2.video_upload_status')==0 ? 'checked' : (isset($frontend_video_box_2['video_upload_status']) && $frontend_video_box_2['video_upload_status']==0 ? 'checked' :'') }} value="0" id="frontend_video_box_2_upload" >
                            <label class="form-check-label" for="frontend_video_box_2_upload">
                                Upload video
                            </label>
                        </div>
                        @error('frontend_support.frontend_video_box_2.video_upload_status')<span class="error invalid-feedback">{{ $message }}</span>@enderror

                    </div>
                    <div class="form-group row frontend_video_box_2_youtube">

                        <label for="video_source_2" class="col-sm-3 col-form-label">Youtube:</label>
                        <div class="col-sm-8">
                            <input type="text" name="frontend_support[frontend_video_box_2][youtube]" class="form-control @error('frontend_support.frontend_video_box_2.youtube') is-invalid @enderror" value="{{ old('frontend_support.frontend_video_box_2.youtube')?:$frontend_video_box_2['youtube']??null }}">
                            @error('frontend_support.frontend_video_box_2.youtubee')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group row frontend_video_box_2_upload">

                        <label for="video_source_2" class="col-sm-3 col-form-label">Video Upload:</label>
                        <div class="col-sm-8">
                            <div class="col-sm-10">
                                <input type="file" name="frontend_support[frontend_video_box_2][video_upload]" id="video_upload_1" class="form-control-file">
                                <small class="text-muted" style="margin-top: 5px;">Allowed Dimension: <kbd>270px</kbd> by <kbd>60px</kbd></small>
                                <br/>
                                <small class="text-muted" style="margin-top: 5px;"> Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>,
                                    Allowed Extensions: <kbd>mp4</kbd>,<kbd>mov</kbd>,<kbd>ogg</kbd>
                                </small>
                                @error('frontend_support.frontend_video_box_2.video_upload')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                @if( isset($frontend_video_box_2['video_upload']) && $frontend_video_box_2['video_upload'] && is_exists_file(  Setting::$storage_disk . '/'. $frontend_video_box_2['video_upload'])  )

                                    <div id="frame_video_remove_2">
                                        <input type="hidden" name="frontend_support[frontend_video_box_2][h_video_upload]" value="{{ $frontend_video_box_2['video_upload'] ?? null }}">
                                        <br/><br/>
                                        <video width="300" class="video_frame" controls>
                                            <source src="{{ Setting::getImageUrl($frontend_video_box_2['video_upload']) }}">
                                        </video>
                                        <span id="video_remove_2" class="btn btn-danger">Remove</span>
                                        <input type="hidden" class="video_remove_2"  name="frontend_support[frontend_video_box_2][remove_video]" value="0">
                                    </div>

                                @endif
                            </div>

                        </div>
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


