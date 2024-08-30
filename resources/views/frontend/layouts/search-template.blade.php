<div class="innerbanner listinginnerbanner mobile-none">
    <div class="custom-container">
        <div class="row">
            <div class="col-md-3">
                <div class="img">
                    @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                        <a href="{{ url('/') }}">
                            <img
                                src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}"
                                alt="{{ $site_settings['sites']['site_name'] }}"/>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <form class="mainsearch" id="searchform" action="#"
                    {{ Route::is(front_route('page.hospital.list'))? '' : 'data-action="'.route(front_route('page.hospital.list')).'"' }}>
                    <div class="search">
                        <select class="select2" style="width: 100%;">
                        </select>
                        <input class="select2-selection__rendered_show" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}" name="name" hidden style="width: 100%;">

                    </div>
                    <div class="spann-or">OR</div>
                    <div class="zipcode">
                        <input type="text" name="zipcode" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="pac-input" placeholder="Start with 3 digits of Zipcode" value="{{request()->get('zipcode')??''}}">
                        <input type="hidden" name="zipcode_hidden" value="{{request()->get('zipcode_hidden')??''}}">
                        <i class="far fa-compass"></i>
                    </div>
                    <input type="submit" name="submit" value="Search" id="searchformbutton" class="btn ">
                </form>
            </div>
        </div>
    </div>
</div>


<div class="mobile-visible">

    <i class="fas fa-times"></i>
    <div class="custom-container">
        <div class="row">
            <div class="col-md-3">
                <div class="img">
                    @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                        <a href="{{ url('/') }}">
                            <img
                                src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}"
                                alt="{{ $site_settings['sites']['site_name'] }}"/>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <form class="mainsearch" id="searchform" action="#"
                    {{ Route::is(front_route('page.hospital.list'))? '' : 'data-action="'.route(front_route('page.hospital.list')).'"' }}>
                    <div class="search">
                        <select class="select2" style="width: 100%;">
                        </select>
                        <input class="select2-selection__rendered_show" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}" name="name" hidden style="width: 100%;">

                    </div>
                    <div class="spann-or">OR</div>
                    <div class="zipcode">
                        <input type="text" name="zipcode"  maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  class="pac-input" placeholder="Start with 3 digits of Zipcode" value="{{request()->get('zipcode')??''}}">
                        <input type="hidden" name="zipcode_hidden" value="{{request()->get('zipcode_hidden')??''}}">
                        <i class="far fa-compass"></i>
                    </div>
                    <input type="submit" name="submit" value="Search" id="searchformbutton" class="btn ">
                </form>
            </div>
        </div>
    </div>
</div>
