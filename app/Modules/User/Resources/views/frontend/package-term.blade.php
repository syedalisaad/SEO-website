@extends( front_layout('master') )
@section('title', 'Payment Terms and Condition')
@section('content')

    @php
        $terms = $data->extras;
    @endphp

    <section class="privacy">
        <div class="custom-container">
            @if(!empty($data->description))
                <div class="row">
                    <div class="col-md-12">
                        <h2>PAYMENT TERMS AND CONDITION

                        </h2>
                        <p>{!! $data->description??'' !!}</p>
                    </div>


                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <h2>TERMS OF SERVICE</h2>
                    </div>
                    <div class="col-md-12">
                        <h2 style="text-decoration: none;">Comming Soon</h2>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
