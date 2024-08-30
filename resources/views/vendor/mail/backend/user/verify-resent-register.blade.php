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
Thank you for your registration for {{ $site_settings['sites']['site_name'] }}. To complete email verification, use the code below. <br/>

{{-- Outro Lines --}}
<center>
In addition, use the following code <br>
<strong>{{ $data->verifytoken }}</strong>
</center>
<br/><br/>

{{-- Salutation --}}
<center><strong>Need Help?</strong></center>
<center>Please send any feedback or bug reports <br> to {{  $site_settings['sites']['email_support'] }}</center>


@endcomponent
