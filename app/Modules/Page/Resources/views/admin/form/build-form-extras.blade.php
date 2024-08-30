@php use \App\Models\Page; @endphp

@if( isset($data) )
    @switch( $data->slug )
        @case( Page::$PAGE_ABOUT)

        <div class="card card-yarn">
            <div class="card-header">
                <h3 class="card-title">Our Vision,Our Mission,Our Values</h3>
            </div>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-sm-4">
                        <label class="cust-label">Our Vision</label>
                        <div class="input-group">
                        <textarea rows="5" name="extras[about][vision]"
                                  class="form-control form-control-sm @error('extras.about.vision') is-invalid @enderror"
                                  placeholder="Our Vision">{{ old('extras.about.vision', $data->extras['about']['vision']??null) }}</textarea>
                            @error('extras.about.vision')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="cust-label">Our Mission</label>
                        <div class="input-group">
                    <textarea rows="5" name="extras[about][mission]"
                              class="form-control form-control-sm @error('extras.about.mission') is-invalid @enderror"
                              placeholder="Our Mission">{{ old('extras.about.mission', $data->extras['about']['mission']??null) }}</textarea>
                            @error('extras.about.mission')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="cust-label">Our Values</label>
                        <div class="input-group">
                    <textarea rows="5" name="extras[about][values]"
                              class="form-control form-control-sm @error('extras.about.values') is-invalid @enderror"
                              placeholder="Our Values">{{ old('extras.about.values', $data->extras['about']['values']??null) }}</textarea>
                            @error('extras.about.values')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                </div>
            </div>
        </div>

        @break
    @endswitch
@endif
