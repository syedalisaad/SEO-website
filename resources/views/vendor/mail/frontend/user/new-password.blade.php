@component('mail::message')
{{-- Greeting --}}
<center>
<a href="{{ url('/') }}" style="  margin-left: auto; margin-right: auto;">
<img src="https://goodhospitalbadhospital.com/storage/settings/logo_1636404353.png" style="vertical-align: middle; backgroud-color:white;" />
</a>
</center>
</br>
<b>Hi, {{ $data->full_name }}!</b><br/>

{{-- Intro Lines --}}
You are receiving this  beacuse your password is change now
<br><br>

{{-- Action Button --}}
<center>
Email Address: {{ $data->email }} <br/>
password     : {{$optional['password']}}
</center>
<br/>

{{-- Salutation --}}
<center><strong>Need Help?</strong></center>
<center>Please send any feedback or bug reports <br> to {{  $site_settings['sites']['email_support'] }}</center>

{{-- Subcopy --}}
{{--@component('mail::subcopy')--}}
{{--<center>{{ $site_settings['sites']['site_name'] }}, {{ $site_settings['contact_support']['contact_email'] }}, {{ $site_settings['contact_support']['contact_number'] }}</center>--}}
{{--<center>{{ $site_settings['contact_support']['address'] }}</center>--}}
{{--<center>{{ $site_settings['sites']['footer_text'] }}</center>--}}
{{--<center>--}}
{{--<div>--}}
{{--<a href="javascript:void(0)"><i class="fa fa-facebook"></i></a>--}}
{{--<a href="javascript:void(0)"><i class="fa fa-twitter"></i></a>--}}
{{--<a href="javascript:void(0)"><i class="fa fa-instagram"></i></a>--}}
{{--<a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a>--}}
{{--<a href="javascript:void(0)"><i class="fa fa-behance"></i></a>--}}
{{--</div>--}}
{{--</center>--}}
{{--@endcomponent--}}

@endcomponent

