@php use App\Models\Setting;

$payment_gatways    = $data['payment_gateway']??null;
@endphp
<form action="{{ route(admin_route('site.save_setting')) }}" method="POST">
    {{ csrf_field() }}
    <div class="card-body">

        <div class="row">

            <div class="col-md-12 col-sm-12">
                <h4>Payment Gateway</h4><br/>
            </div>

            {{-- Stripe - Payment Gateway --}}
            <div class="col-md-6 col-sm-6">
                <div class="p-2" style="border:1px solid #a1a1a1">
                    <h5>Stripe - Payment Gateway</h5><br/>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Client ID:</label>
                        <div class="col-sm-12">
                            <input type="text" name="payment_gateway[stripe][client_id]" class="form-control @error('payment_gateway.stripe.client_id') is-invalid @enderror" value="{{ old('payment_gateway.stripe.client_id')?:$payment_gatways['stripe']['client_id']??null }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Client Secret:</label>
                        <div class="col-sm-12">
                            <input type="text" name="payment_gateway[stripe][client_secret]" class="form-control @error('payment_gateway.stripe.client_secret') is-invalid @enderror" value="{{ old('payment_gateway.stripe.client_secret')?:$payment_gatways['stripe']['client_secret']??null }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Client Webhook:</label>
                        <div class="col-sm-12">
                            <input type="text" name="payment_gateway[stripe][client_webhook]" class="form-control @error('payment_gateway.stripe.client_webhook') is-invalid @enderror" value="{{ old('payment_gateway.stripe.client_webhook')?:$payment_gatways['stripe']['client_webhook']??null }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Mode</label>
                        <div class="col-sm-12">
                            @php $gateway_mode = old('payment_gateway.stripe.gateway_mode')?:$payment_gatways['stripe']['gateway_mode']??null; @endphp
                            <select name="payment_gateway[stripe][gateway_mode]" class="form-control @error('payment_gateway.stripe.gateway_mode') is-invalid @enderror">
                                <option {{ $gateway_mode == Setting::$GATEWAY_MODE_SANDBOX ? 'selected' : '' }} value="{{ Setting::$GATEWAY_MODE_SANDBOX }}"> Sandbox</option>
                                <option {{ $gateway_mode == Setting::$GATEWAY_MODE_LIVE ? 'selected' : '' }} value="{{ Setting::$GATEWAY_MODE_LIVE }}"> Live</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="p-2" style="border:1px solid #a1a1a1">
                    <h5>Packages Activation</h5><br/>
                    @php
                        $package_details =   \App\Models\StripeProduct::isGatwayMode()->get();
                    @endphp
                    @if(count($package_details) > 0)
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Package</th>
                                <th scope="col">Active?</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($package_details as $pack)
                                <tr>
                                    <th scope="row">{{ $loop->index+1 }}</th>
                                    <td>{{ $pack['name'] }}</td>
                                    <td>
                                        <input type="radio" name="stripe_pacakges[{{ $pack['id'] }}][is_active]" {{ $pack['is_active'] == 1 ? 'checked' : '' }} value="1"/> Yes
                                        &nbsp;&nbsp;
                                        <input type="radio" name="stripe_pacakges[{{ $pack['id'] }}][is_active]" {{ $pack['is_active'] == 0 ? 'checked' : '' }} value="0"/> No
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">
                                    <button type="submit" class="btn btn-yarn">Update</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div class="card border-top-0 rounded-0">
        <div class="card-footer">
            <button type="submit" class="btn btn-yarn">Save</button>
        </div>
    </div>
</form>
