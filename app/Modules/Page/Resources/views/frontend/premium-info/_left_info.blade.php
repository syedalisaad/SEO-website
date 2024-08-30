<ul>
    <li>
        <h5>Location:</h5>
        <a>{{$hospital->formatted_address}}</a>
    </li>
    <li>
        <h5>Phone:</h5>
        <a href="tel:{{$hospital->phone_number}}">{{$hospital->phone_number}}</a>
    </li>
    @if($hospital->hospital_info && !empty($hospital->hospital_info->image_url_logo))
        <li class="website-link">
{{--            <h5>Website:</h5>--}}
            <a target="_blank" class="btn btn-template" href="{{$hospital->hospital_info->ref_url}}">Go To Website </a>
        </li>
    @endif
</ul>
@if($hospital->hospital_info && !empty($hospital->hospital_info->image_url_logo) && isset($subscribe_order))
@else
    <a class="hosp-url" href="{{ route(front_route('user.dashboard')) }}">Add Hospital URL</a>
@endif
