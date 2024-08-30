@php use \App\Models\Page; @endphp
<div class="card card-yarn">
    <div class="card-header">
        <h3 class="card-title">Additional Information</h3>
    </div>
    <div class="card-body">
        <div class="row form-group d-none">
            <div class="col-sm-3">
                <label class="mt-2" for="customFile">Header Background</label>
            </div>
            <div class="col-sm-9">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="extras[source_header]">
                    <label class="custom-file-label @error('source_header') is-invalid @enderror"
                           for="customFile"></label>
                    @error('source_header')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <small class="row text-muted col-sm-12" style="margin-top: 5px;">
                    Maximum Upload Size: <kbd>{{ upload_max_filesize_label() }}</kbd>
                    @if( isset($data) && $data->page_header_url )
                        <input type="hidden" name="extras[h_source_header]"
                               value="{{ $data['extras']['source_header'] }}">
                        <a href="{{ $data->page_header_url }}" target="_blank" class="ml-1">View</a>
                        {{--<a href="{{ route( admin_route('page.removesource'), $data->id ) }}" class="ml-1 text-red">Remove</a>--}}
                    @endif
                </small>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">Sub Heading</label>
                <div class="input-group">
                    <input type="text" name="extras[sub_heading]"
                           class="form-control form-control-sm @error('sub_heading') is-invalid @enderror"
                           value="{{ $data->extras['sub_heading'] ?? old('sub_heading') }}" placeholder="Sub Heading"/>
                    @error('sub_heading')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        @if( isset($data) )
            @switch( $data->slug )
                {{-- FAQ's --}}
                @case( Page::$PAGE_FAQ)
                @php
                    $faqs = old('extras.faq')?:[];
                    $faq_count = count($faqs)?:1;
                    if( isset($data) && isset($data->extras['faq'][0]['name']) )
                    {
                        $faqs = $data->extras['faq'];
                        $faq_count = count($faqs);
                    }
                @endphp
                <div class="const-faqs-container">
                    @for($i=0;$i<$faq_count;$i++)
                        <div class="faq-container-box"
                             style="border:1px solid darkgrey; margin-bottom: 10px; padding: 20px; border-radius: 6px;">
                            <div class="row form-group">
                                <div class="col-sm-11">
                                    <label class="cust-label">FAQ Question</label>
                                    <div class="input-group">
                                        <input type="text" name="extras[faq][{{ $i }}][name]"
                                               class="const-faq-name form-control form-control-sm @error('extras.faq.'.$i.'.name') is-invalid @enderror"
                                               value="{{ $faqs[$i]['name']??null }}" placeholder="FAQ Question"/>
                                        @error('extras.faq.'.$i.'.name')<span
                                            class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <a href="javascript:void(0)"
                                       class="btn btn-danger btn-sm mt-4 const-faq-delete {{ $i==0?'display-none':'' }}"><i
                                            class="fas fa-trash"></i></a>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <label class="cust-label">Description</label>
                                    <div class="input-group">
                                        <textarea maxlength="500" name="extras[faq][{{ $i }}][content]" rows="3"
                                                  class="const-faq-content form-control @error('extras.faq.'.$i.'.content') is-invalid @enderror"
                                                  placeholder="Description">{{ $faqs[$i]['content']??null }}</textarea>
                                        @error('extras.faq.'.$i.'.content')<span
                                            class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

        @section('additional_footer')
            <div class="card-footer">
                <button type="button" class="btn btn-yarn const-add-faq">Add FAQ's</button>
            </div>
        @endsection
        @push('scripts')
            <script>
                $(function () {
                    let faq_container = $('.const-faqs-container');

                    $(document).on('click', '.const-add-faq', function () {

                        let faq_leng = $('.faq-container-box').length;
                        let faqClone = $('.faq-container-box:first').clone();
                        faqClone.find('input, textarea').val('');
                        faqClone.find('.const-faq-name').attr('name', 'extras[faq][' + faq_leng + '][name]');
                        faqClone.find('.const-faq-content').attr('name', 'extras[faq][' + faq_leng + '][content]');
                        faqClone.find('.const-faq-delete').removeClass('display-none');

                        faq_container.append(faqClone)
                    });

                    $(document).on('click', '.const-faq-delete', function () {
                        $(this).closest('.faq-container-box').remove();
                    });
                })
            </script>
        @endpush
        @break
        {{--        terms of services--}}
        @case( Page::$PAGE_TERMS_OF_SERVICE)
        @php
            $terms = old('extras.terms')?:[];
            $terms_count = count($terms)?:1;

            if( isset($data) && isset($data->extras['terms'][0]['name']))
            {
                $terms = $data->extras['terms'];
                $terms_count = count($terms);
            }
        @endphp
        <div class="const-terms-container">
            @for($i=0;$i<$terms_count;$i++)
                <div class="terms-container-box"
                     style="border:1px solid darkgrey; margin-bottom: 10px; padding: 20px; border-radius: 6px;">
                    <div class="row form-group">
                        <div class="col-sm-11">
                            <label class="cust-label">Heading Name</label>
                            <div class="input-group">
                                <input type="text" name="extras[terms][{{ $i }}][name]"
                                       class="const-terms-name form-control form-control-sm @error('extras.terms.'.$i.'.name') is-invalid @enderror"
                                       value="{{ $terms[$i]['name']??null }}" placeholder="Terms Heading"/>
                                @error('extras.terms.'.$i.'.name')<span
                                    class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <a href="javascript:void(0)"
                               class="btn btn-danger btn-sm mt-4 const-terms-delete {{ $i==0?'display-none':'' }}"><i
                                    class="fas fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label class="cust-label">Description</label>
                            <div class="input-group">
                                        <textarea maxlength="500" name="extras[terms][{{ $i }}][content]" rows="3"
                                                  class="texteditor const-terms-content form-control @error('extras.terms.'.$i.'.content') is-invalid @enderror"
                                                  placeholder="Description">{{ $terms[$i]['content']??null }}</textarea>
                                @error('extras.terms.'.$i.'.content')<span
                                    class="error invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        @section('additional_footer')
            <div class="card-footer">
                <button type="button" class="btn btn-yarn const-add-terms">Add Terms</button>
            </div>
        @endsection
        @push('scripts')
            <script>
                $(function () {
                    let terms_container = $('.const-terms-container');

                    $(document).on('click', '.const-add-terms', function () {

                        let terms_leng = $('.terms-container-box').length;
                        let termsClone = $('.terms-container-box:first').clone();
                        termsClone.find('input, textarea').val('');
                        termsClone.find('.const-terms-name').attr('name', 'extras[terms][' + terms_leng + '][name]');
                        termsClone.find('.const-terms-content').attr('name', 'extras[terms][' + terms_leng + '][content]');
                        termsClone.find('.const-terms-delete').removeClass('display-none');

                        terms_container.append(termsClone)
                    });

                    $(document).on('click', '.const-terms-delete', function () {
                        $(this).closest('.terms-container-box').remove();
                    });
                })
            </script>
        @endpush
        @break
        {{--         About Us --}}
        @case(Page::$PAGE_ABOUT)
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">The Problem</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][problem]"
                              class="form-control form-control-sm @error('extras.about.problem') is-invalid @enderror"
                              placeholder="The Problem">{{ old('extras.about.problem', $data->extras['about']['problem']??null) }}</textarea>
                    @error('extras.about.problem')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">What We Are</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][what_we_are]"
                              class="form-control form-control-sm @error('extras.about.what_we_are') is-invalid @enderror"
                              placeholder="What We Are">{{ old('extras.about.what_we_are', $data->extras['about']['what_we_are']??null) }}</textarea>
                    @error('extras.about.what_we_are')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">What We Are Not</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][what_we_are_not]"
                              class="form-control form-control-sm @error('extras.about.what_we_are_not') is-invalid @enderror"
                              placeholder="What We Are Not">{{ old('extras.about.what_we_are_not', $data->extras['about']['what_we_are_not']??null) }}</textarea>
                    @error('extras.about.what_we_are_not')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">Why did we do this</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][why_did_we_do_this]"
                              class="form-control form-control-sm @error('extras.about.why_did_we_do_this') is-invalid @enderror"
                              placeholder="Why did we do this">{{ old('extras.about.why_did_we_do_this', $data->extras['about']['why_did_we_do_this']??null) }}</textarea>
                    @error('extras.about.why_did_we_do_this')<span
                        class="error invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">Work in Progress</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][work_in_progress]"
                              class="form-control form-control-sm @error('extras.about.work_in_progress') is-invalid @enderror"
                              placeholder="Work in Progress">{{ old('extras.about.work_in_progress', $data->extras['about']['work_in_progress']??null) }}</textarea>
                    @error('extras.about.work_in_progress')<span
                        class="error invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <label class="cust-label">Why a Panda? (We are glad you asked.)</label>
                <div class="input-group">
                    <textarea rows="5" name="extras[about][why_a_panda]"
                              class="form-control form-control-sm @error('extras.about.why_a_panda') is-invalid @enderror"
                              placeholder="Why a Panda? (We are glad you asked.)">{{ old('extras.about.why_a_panda', $data->extras['about']['why_a_panda']??null) }}</textarea>
                    @error('extras.about.why_a_panda')<span
                        class="error invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        @break
        @endswitch
        @endif

    </div>

    @yield('additional_footer')

</div>

