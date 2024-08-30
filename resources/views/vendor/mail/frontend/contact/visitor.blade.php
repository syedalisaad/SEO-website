@component('mail::message')
{{-- Greeting --}}
# Hi {!! $data['name'] !!}, <br/><br/>

{{-- Intro Lines --}}
Thank you for getting in touch!
<br><br>

{{-- Intro Lines --}}
{!! $data['message'] !!}
<br><br>

Thanks in advance for your patience.
<br><br>

Have a great day!
<br><br>

{{-- Salutation --}}
<center><strong>Need Help?</strong></center>
<center>Please send any feedback or bug reports <br> to {{  $site_settings['sites']['email_support'] }}</center>

{{-- Subcopy --}}
@component('mail::subcopy')
<center>{{ $site_settings['sites']['site_name'] }}, {{ $site_settings['contact_support']['contact_email'] }}, {{ $site_settings['contact_support']['contact_number'] }}</center>
<center>{{ $site_settings['contact_support']['address'] }}</center>
<center>{{ $site_settings['sites']['footer_text'] }}</center>
<center>
    <div>
        <a href="javascript:void(0)"><i class="fa fa-facebook"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-twitter"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-instagram"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-behance"></i></a>
    </div>
</center>
@endcomponent

@endcomponent

