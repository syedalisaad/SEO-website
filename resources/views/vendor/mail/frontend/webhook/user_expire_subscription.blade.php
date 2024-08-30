@component('mail::message')
{{-- Greeting --}}
# Hi {!! $data->first_name !!}, <br/><br/>

{{-- Intro Lines --}}
We hope you’ve been enjoying our services of Good Hospital Bad Hospital so far!<br>
Your subscription period will expire in a week, so we thought we’d check in about next steps<br>
<br>

<strong>NOTE:</strong> Subscription will automatically renewed if you have amount in the account else click on Renew Now for further processing.
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

