@extends( front_layout('master') )
@section('title', 'Email')
@section('content')

    <section class="emailupdate">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <h2>Don't miss any update</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/newsletter.webp'))}}">
                    </div>
                    <p>Subscribe to get the latest news and updates.<br> No spam, we promise.</p>
                    <form class="newsletter" form method="POST" action="#"  id="newsletters_email"
                          data-action="{{ route( front_route('page.newsletter')) }}">
                        <div class="col-lg-12">
                            <input type="email" name="email" placeholder="Email">
                            <input type="submit" name="send" value="Subscribe">
                            <div class="response_msg"></div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
@endsection
