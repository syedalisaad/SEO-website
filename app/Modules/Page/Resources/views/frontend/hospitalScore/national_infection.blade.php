@extends( front_layout('master') )
@section('title', $page_title)
@section('content')
@section('meta_tags')
    <meta property="url" content="{{ route(front_route('page.national.infection')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    <meta property="og:url" content="{{ route(front_route('page.national.infection')) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $page_title }}" />
    @php $site_settings = get_site_settings(); @endphp
    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image:url" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta name="twitter:image:src" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta name="twitter:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
    @endif
@endsection
    <div class="unsubscribe infection">
        <div class="custom-container">
            <div class="row listings">
                <div class="col-md-9">
                    <h2>National Infection Measurements</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-infection.webp'))}}" alt="single-infection">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_1_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    According to the CDC, a central line is like an IV, but instead of being put in a peripheral location like the hand or arm, these are long term access points for the administration of medicine and fluids and/or the collection of blood. Because these access points can be in place for weeks or months, they can be prone to infection. Strict medical procedures are in place for keeping the area clean and maintained.
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_2_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    According to the CDC, this is any infection of the urinary system when a catheter is in place. It is the most common type of healthcare-related infection as reported by the National Healthcare Safety Network.
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_3_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    An SSI is a surgical site infection. This measurement is specifically measuring surgical site infections associated with colon surgery.
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_4_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    An SSI is a surgical site infection. This measurement is specifically measuring surgical infections related with a hysterectomy.
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_5_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    MRSA stands for Methicillin-resistant Staphylococcus aureus. This measurement tracks the type of bacterial infection that is resistant to antibiotics.
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <div class="data">
                                <div class="tags">
                                    {{NationalScoreDetails('NATIONAL','HAI_6_SIR','PatientInfection')->measure_name??""}}
                                </div>
                                <div class="txt">
                                    C. Diff is a bacterium that causes severe diarrhea. According to the CDC, 1 in 11 people who get over the age of 65 will die within a month. This measurement tracks the cases related to C.Diff infections.
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            @include( frontend_module_view('hospitalScore.more-info-national', 'Page'))


        </div>
    </div>

@endsection

@push('modals')
    <div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Share</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="p-0">
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="twitter">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="linkedin">
                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks" data-channel="copy">
                                        <i class="fas fa-copy" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
