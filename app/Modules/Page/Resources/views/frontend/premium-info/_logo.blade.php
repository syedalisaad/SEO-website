@if($hospital->hospital_info && !empty($hospital->hospital_info->image_url_logo) && isset($subscribe_order))
    <img src="{{$hospital->hospital_info->image_url_logo}}">
@endif
