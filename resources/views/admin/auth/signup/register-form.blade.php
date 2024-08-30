@php
$default_PK_id      = \App\Country::$COUNTRY_PAKISTAN;
$exists_session     = \Session::get('previous_session') ?? [];

$cities             = [];
$country_id         = (int) (old('country_id') ?? $exists_session['country_id'] ?? 0);
$countries          = \App\Country::getAllLists();
$categories         = \App\Category::getParentCategories();
$businesses         = \App\BusinessType::getLists();

if( $country_id  > 0) {
    $cities = \App\City::getCitiesByCountry( $country_id );
}
@endphp

<div class="row">
    <div class="col-md-6 form-group {{ ((old('first_name')??$exists_session['first_name']??null) ? 'float' : '') }}">
        <label class="abs-float">First Name <span class="text-denger font-weight-bold">*</span></label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $exists_session['first_name'] ?? '' }}" />
        @error('first_name')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6 form-group {{ ((old('last_name')??$exists_session['last_name']??null) ? 'float' : '') }}">
        <label class="abs-float">Last Name <span class="text-denger font-weight-bold">*</span></label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $exists_session['last_name'] ?? '' }}" />
        @error('last_name')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group {{ ((old('email')??$exists_session['email']??null) ? 'float' : '') }}">
        <label class="abs-float">Email <span class="text-denger font-weight-bold">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email') ?? $exists_session['email'] ?? '' }}" />
        @error('email')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6 form-group {{ ((old('company')??$exists_session['company']??null) ? 'float' : '') }}">
        <label class="abs-float">Company Name {!! $type_of == 'buyer' ? '' : '<span class="text-denger font-weight-bold">*</span>' !!}</label>
        <input type="text" class="form-control @error('company') is-invalid @enderror" name="company"  value="{{ old('company') ?? $exists_session['company'] ?? '' }}" />
        @error('company')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group {{ ((old('password')??$exists_session['password']??null) ? 'float' : '') }}">
        <label class="abs-float">Password <span class="text-denger font-weight-bold">*</span></label>
        <input type="password" class="form-control  @error('password') is-invalid @enderror"  name="password" value="{{ old('password') ??$exists_session['password']?? '' }}">
        @error('password')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6 form-group {{ ((old('confirm_password')??$exists_session['confirm_password']??null) ? 'float' : '') }}">
        <label class="abs-float">Confirm Password <span class="text-denger font-weight-bold">*</span></label>
        <input type="password" class="form-control  @error('confirm_password') is-invalid @enderror"  name="confirm_password" value="{{ old('confirm_password') ??$exists_session['confirm_password']?? '' }}">
        @error('confirm_password')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
@php

@endphp
<div class="row">
    <div class="col-md-6 form-group">
        <select class="form-control constCountry @error('country_id') is-invalid @enderror" name="country_id">
            <option disabled selected value="">Country <span class="text-denger font-weight-bold">*</span></option>
            @if( isset($countries) && count($countries) )
                @foreach($countries as $value)
                    <option data-country-code="{{ $value['code'] }}" {{ (old('country_id')??$exists_session['country_id']??0) == $value['id'] ? 'selected' : null }} value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                @endforeach
            @endif
        </select>
        @error('country_id')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6 form-group">
        <select class="form-control constCity @error('city_id') is-invalid @enderror" name="city_id">
           <option disabled selected value="">City <span class="text-denger font-weight-bold">*</span></option>
            @if( count($cities) )
               @foreach($cities as $row_id => $row_name )
                   <option {{ (old('city_id')??$exists_session['city_id']) == $row_id ? 'selected' : null }} value="{{ $row_id }}">{{ $row_name }}</option>
               @endforeach
           @endif
       </select>
       @error('city_id')
           <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
       @enderror
    </div>
</div>
@php
$is_pk      = ((old('country_id')??$exists_session['country_id']??0) == $default_PK_id);
$is_number  = (
    $is_pk && (($errors->has('cnic') || $errors->has('ntn') || $errors->has('strn')) || ((old('cnic')??$exists_session['cnic']??null) || (old('ntn')??$exists_session['ntn']??null) || (old('strn')??$exists_session['strn']??null)))
);
@endphp
<div class="row const-bs-numb-container" style="display: {{ $is_number ? 'inline-flex' : 'none' }}">
    <div class="col-md-4 form-group {{ ((old('cnic')??$exists_session['cnic']??null) ? 'float' : '') }}">
        <label class="abs-float">CNIC</label>
        <input type="text" class="form-control @error('cnic') is-invalid @enderror" name="cnic" value="{{ old('cnic') ??$exists_session['cnic']??'' }}"/>
        @error('cnic')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 form-group {{ ((old('ntn')??$exists_session['ntn']??null) ? 'float' : '') }}">
        <label class="abs-float">NTN</label>
        <input type="text" class="form-control @error('ntn') is-invalid @enderror" name="ntn" value="{{ old('ntn') ?? $exists_session['ntn'] ?? '' }}" />
        @error('ntn')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 form-group {{ ((old('strn')??$exists_session['strn']??null) ? 'float' : '') }}">
        <label class="abs-float">STRN</label>
        <input type="text" class="form-control @error('strn') is-invalid @enderror" name="strn" value="{{ old('strn') ?? $exists_session['strn'] ?? '' }}" />
        @error('strn')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
{{--        <label class="abs-float">Phone Number</label>--}}
        <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')??$exists_session['phone']??'' }}" />
        <input type="hidden" id="dialcode" name="dialcode"  value="{{ old('dialcode')??$exists_session['dialcode']?? '' }}" />
        @error('phone')
            <span class="error invalid-feedback" style="display: block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    @if( $type_of != 'buyer' )
    <div class="col-md-6 form-group">
        <label class="abs-select {{ (old('category_id')??$exists_session['category_id']??null) ? 'selected' : '' }}" for="select">Categories</label>
        <select class="form-control const-categories select2 @error('category_id') is-invalid @enderror" name="category_id[]" multiple>
           @if( isset($categories) && count($categories) )
               @foreach($categories as $key => $value)
                   <option {{  in_array($key, old('category_id')??$exists_session['category_id']??[]) ? 'selected' : null }}  value="{{ $key }}">{{ $value }}</option>
               @endforeach
               <option {{  in_array("other", old('category_id')??$exists_session['category_id']??[]) ? 'selected' : null }}  value="other">Other</option>
           @endif
       </select>
        @error('category_id')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    @endif

    <div class="col-md-6 form-group">
        <label class="abs-select {{ (old('business_id')??$exists_session['business_id']??null) ? 'selected' : '' }}" for="select">Businesses</label>
        <select multiple class="const-businesses form-control select2 @error('business_id') is-invalid @enderror" name="business_id[]">
           @if( isset($businesses) && count($businesses) )
               @foreach($businesses as $key => $value)
                    <option {{  in_array($key, old('business_id')??$exists_session['business_id']??[]) ? 'selected' : null }}  value="{{ $key }}">{{ $value }}</option>
               @endforeach
               <option {{  in_array("other", old('business_id')??$exists_session['business_id']??[]) ? 'selected' : null }}  value="other">Other</option>
           @endif
       </select>
        @error('business_id')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
@php
$is_other = (in_array('other', old('business_id') ?: []) || in_array('other', old('category_id') ?: []));
$is_other = ( $is_other && ($errors->has('others') || old('others')));
@endphp
<div class="row const-cb-container" style="display: {{ $is_other ? 'block' : 'none' }}" >
    <div class="col-md-12 form-group {{ (old('others') ? 'float' : '') }}">
        <label class="abs-float">Others <span class="text-denger font-weight-bold">*</span></label>
        <textarea class="form-control @error('others') is-invalid @enderror" name="others" >{{ old('others') ?: '' }}</textarea>
        @error('others')
            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
<div class="row form-group i-agree">
    <div class="col-md-12">
        <label>
            <input type="checkbox" name="i_agree" value="1"> <sup class="text-denger">*</sup> I Agree to Terms & Conditions
        </label>
        @error('i_agree')
            <br/><span class="error text-danger" style="font-size: 80%;"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    $(function () {

        /*$(".const-categories").select2({ placeholder: "Categories", allowClear: true});
        $(".const-businesses").select2({ placeholder: "Businesses", allowClear: true});*/
        //$('.const-bs-numb-container').hide();
        //$('.const-cb-container').hide();

        let opt_phone = document.querySelector("#phone");
        window.intlTelInputGlobals.getInstance(opt_phone);

        let itl = window.intlTelInput(opt_phone, {
            allowDropdown: true,
            autoHideDialCode: true,
            formatOnDisplay: true,
            separateDialCode: true,
            excludeCountries: ['il'],
            initialCountry: "us",
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {}, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "{{ admin_asset('/dist/js/utils.js')  }}",
        });

        @if( (old('dialcode')??$exists_session['dialcode']??null) )
            let diaphone = "{{ (old('dialcode')??$exists_session['dialcode']??0) . (old('phone')??$exists_session['phone']??null) }}";
            itl.setNumber(diaphone);
        @endif

        opt_phone.addEventListener("countrychange", function () {
            var dialCode = $(".iti__selected-dial-code").html();
            $('input[name="dialcode"]').val(dialCode);
        });

        //Get All Of Cities By Country
        if( $(".constCountry").length )
        {
            $(".constCountry").on('change', function(){

                let select_city     = $('.constCity');
                var opt_html        = '<option value="" disabled selected>Select your city</option>';
                let select_option   = $(this).find('option:selected');

                $('.const-bs-numb-container').hide();

                //select country
                itl.setCountry( select_option.data('country-code') );

                if( select_option.text() == 'Pakistan') {
                    $('.const-bs-numb-container').css('display', 'inline-flex');
                }

                const api_url       = ('{{ route( 'buyer.city', ':id') }}').replace(':id', $(this).val());

                $.get(api_url).done(function( response ){

                    if( response.status == true ) {

                        let data = response.collection;
                        $.each(data.data, function(index, value){
                            opt_html += '<option value="'+index+'">'+value+'</option>';
                        })

                        select_city.html( opt_html );
                    }
                });

                select_city.html( opt_html );
            });
        }

        $('.const-businesses, .const-categories').on('change', function () {

            let checked_text = $('.const-businesses, .const-categories').find(':checked').text();
            $('.const-cb-container').hide();

            if( checked_text.indexOf('Other') != -1)  {
                $('.const-cb-container').show();
            }
        });
    })
</script>
@endpush
