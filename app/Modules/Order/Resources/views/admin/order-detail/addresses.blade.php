<address>
    <strong>{{ $address->full_name }}.</strong><br>
    {{ $address->address }}<br>

    @if( $address->country || $address->state || $address->city )
    {{ $address->country }} {{ $address->state }}, {{ $address->city }}<br>
    @endif
    Phone: {{ $address->phone }}<br>
    Email: {{ $address->email }}
</address>
