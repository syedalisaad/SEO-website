<div class="totalscore">
    <div class="score">
        <h6>Over All CMS Score:</h6>
        @if($hospital->hospital_overall_rating!='Not Available')
            <div class="stars" disabled data-rating="{{$hospital->hospital_overall_rating}}"></div>
        @else
            <p>{{$hospital->hospital_overall_rating}}</p>
        @endif    </div>
    <div class="score">
        <h6>Patient Summary:</h6>

        @if(isset($hospital->summary_patients->patient_survey_star_rating) && $hospital->summary_patients->patient_survey_star_rating!='Not Available')

            <div class="stars" read-only="true" data-rating="{{isset($hospital->summary_patients->patient_survey_star_rating)?$hospital->summary_patients->patient_survey_star_rating:''}}"></div>
        @else
            <p>{{isset($hospital->summary_patients->patient_survey_star_rating)?$hospital->summary_patients->patient_survey_star_rating:'-'}}</p>
        @endif    </div>
</div>
