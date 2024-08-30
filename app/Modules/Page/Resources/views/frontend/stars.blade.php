<div class="survey">

    <ul>
        <li>
            <h6>Over All CMS Score:</h6>
            @if($hospital['hospital_overall_rating']!='Not Available')
                <div class="stars" read-only="true" data-rating="{{$hospital['hospital_overall_rating']}}"></div>
            @else
                <div>{{$hospital['hospital_overall_rating']}}</div>
            @endif
        </li>
        <li>
            <h6>Patient Summary:</h6>
            @if(isset($hospital['patient_survey_star_rating']) && $hospital['patient_survey_star_rating']!='Not Available')

                <div class="stars" read-only="true" data-rating="{{isset($hospital['patient_survey_star_rating'])?$hospital['patient_survey_star_rating']:''}}"></div>
            @else
                <div>{{isset($hospital['patient_survey_star_rating'])?$hospital['patient_survey_star_rating']:'-'}}</div>
            @endif
        </li>
    </ul>
</div>
