@component('mail::message')
<style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');</style>

{{-- Greeting --}}
<div style="margin: -32px;">
<center style="padding: 35px 0;">
<a href="{{ url('/') }}" style="  margin-left: auto; margin-right: auto;">
<img src="https://goodhospitalbadhospital.com/storage/settings/logo_1636404353.png" style="vertical-align: middle; backgroud-color:white;" />
</a>
</center>
<div style="background: #003399; text-align: center; padding: 40px 50px;">
<img style="margin: 0 0 15px; width: 150px" src="{{asset(front_asset('images/email-email.png'))}}">
<h6 style="color: #fff; text-transform: uppercase;  font-weight: 500; letter-spacing: 3px; font-size: 16px; margin: 0 0 10px;">Congratulations!</h6>
<h4 style="color: #fff; font-size: 28px;  font-weight: 600; margin: 0;">Hospital Has Been Approved!</h4>
</div>
<div style="padding: 33px 40px 55px; text-align: center;">
<?php
if($data->full_name )
{
$fullname = $data->full_name ;
$name =explode(" ",$fullname);
}

?>
<span style="font-size: 22px;  line-height: 30px; color: #000; width: 100%;">Hi {{$name[0]??''}},</span>

@php $hospital = $data->detail->hospital; @endphp
{{-- Intro Lines --}}
Congratulations - Your hospital "{{ $hospital->facility_name }}" has been approved!
<br><br>

{{-- Outro Lines --}}
<strong>Hospital Information</strong> <br>
<strong>Name</strong> - {{ $hospital->facility_name }}  <br>
<strong>Phone</strong> - {{ $hospital->phone_number }} <br>
<strong>Website</strong> - {{ $hospital->ref_url }} <br>
<br/>

<div style="padding: 0px 40px 0px; text-align: center;">
<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;">Thanks,</span>
<br>
<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 0px; width: 100%;">{!! email_template_sitename($site_settings) !!}</span>
</div>
</div>

<div style="background: #e5eaf5; padding: 35px 0px 15px; text-align: center;">
<h4 style="color: #003399; font-size: 20px; line-height: 30px;  margin: 0 0 5px; width: 100%;">Get in touch</h4>
@if($site_settings['contact_support']['contact_number'] !== '')
<a style="font-size: 16px; text-decoration: none;  line-height: 26px; color: #000; width: 100%;" href="tel:+{{ preg_replace( '/[^0-9]/', '', $site_settings['contact_support']['contact_number']) }}">{{  $site_settings['contact_support']['contact_number'] }}</a>
@else
<a style="font-size: 16px; text-decoration: none;  line-height: 26px; color: #000; width: 100%;" href="#"></a>
@endif
<br>
<a style="font-size: 16px; text-decoration: none;  line-height: 26px; color: #000; width: 100%;" href="mailto:{{  $site_settings['sites']['email_info'] }}">{{  $site_settings['sites']['email_info'] }}</a>
</div>
<div style="background: #003399; text-align: center; color: #fff;  font-size: 15px; padding: 13px 10px;">Copyrights © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</div>
</div>
{{-- Salutation --}}


@endcomponent
