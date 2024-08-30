@component('mail::message')
{{--Greeting--}}


<style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');</style>

{{-- Greeting --}}
<div style="margin: -32px;">
<center style="padding: 35px 0;">
<a href="{{ url('/') }}" style="  margin-left: auto; margin-right: auto;">
<img src="https://goodhospitalbadhospital.com/storage/settings/logo_1636404353.png" style="vertical-align: middle; backgroud-color:white;"/>
</a>
</center>
<div style="background: #003399; text-align: center; padding: 40px 50px;">
<img style="margin: 0 0 15px; width: 150px" src="{{asset(front_asset('images/email-email.png'))}}">
{!!  $data['h6']?'<h6 style="color: #fff; text-transform: uppercase;  font-weight: 500; letter-spacing: 3px; font-size: 16px; margin: 0 0 10px;">'.$data['h6'].'</h6>':''!!}
{!! $data['h4']?'<h4 style="color: #fff; font-size: 28px;  font-weight: 600; margin: 0;">'.$data['h4'].'</h6>':''!!}
</div>
<div style="padding: 33px 40px 55px; text-align: center;">
<span style="font-size: 22px;  line-height: 30px; color: #000; width: 100%;">Hi,</span>
<br>
<div style="padding: 0px 40px 0px; text-align: center;">
{!! $data['content'] !!}
</div>
<br>

{{-- Action Button --}}
@if(isset($data['approval_required']) && $data['approval_required'])
@component('mail::button', ['url' => route( admin_route('hospitalsurvey.form.change_info_req'), $data->id )])
    Click here to Approve Content
@endcomponent
@endif

<center>
<table style="text-align: left;">

<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Email</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px">{{auth()->user()->email??$data['email']}}</td>
</tr>

<tr>

<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Phone</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px">{{$data->phone_number}}</td>
</tr>
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Name</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px">{{$data->name}}</td>
</tr>
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Website URL</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px">{!!$data->ref_url?'<a href="'.$data->ref_url.'"> click here</a>':''!!}</td>
</tr>
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Logo image</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><a href="{{$data->image_url_logo}}"> <img src="{{$data->image_url_logo}}" style="width: 100px; height: 100px; object-fit: cover;  "></a></td>
</tr>
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Main Image</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><a href="{{$data->image_url_right}}"> <img src="{{$data->image_url_right}}" style="width: 100px; height: 100px; object-fit: cover;  "></a></td>
</tr>
{{--{{dd($data)}}--}}
@if(isset($data['video']) && $data['video'])
@if($data['video']>=1)
@if($data->video_one)
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Video One </strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><a href="{{$data->url_video_one}}"> click here</a></td>
</tr>
@endif
@endif
@if($data['video']>=2)
@if($data->video_two)
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Video Two </strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><a href="{{$data->url_video_two}}"> click here</a></td>
</tr>
@endif
@endif
@if($data['video']>=3)

@if($data->video_three)
<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Video Three </strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><a href="{{$data->url_video_three}}"> click here</a></td>
</tr>
@endif
@endif
@endif

<tr>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px"><strong>Publish</strong></td>
<td style="font-size: 16px;  line-height: 28px; color: #000; padding-left: 15px; min-width: 30px">{{$data->is_publish==1?"Active":"Inactive"}}</td>
</tr>
</table>
</center>

<br>
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

