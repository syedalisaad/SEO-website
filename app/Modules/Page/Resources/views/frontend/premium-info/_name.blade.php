@if($hospital->hospital_info && !empty($hospital->hospital_info->name))
    {{strtolower($hospital->hospital_info->name)}}
@else
    {{strtolower($hospital->facility_name)}}
@endif
{!! $hospital->industry_leader == 1 ?
'<div class="industry_leader"><img src="'.asset(front_asset('images/industryleader.png')).'"/>Industry Leader</div>':''
!!}
