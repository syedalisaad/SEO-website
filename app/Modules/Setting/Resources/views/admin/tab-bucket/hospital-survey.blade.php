<div class="card-body">
    <form class="form-group p-2 border border-dark" action="{{ route('admin.site.postHospitalSurveyJobs') }}" method="POST">
        @csrf
        <h4>General Hospital Details</h4><br/>
        <input type="hidden" value="GENERAL_HOSPITAL" name="type_of">
        <div class="row  border-top-0 rounded-0">
            <div class="col-01 p-2 timezone">
                <div class="form-check">
                    <label class="form-check-label" for="timezone">
                        Time Zone
                    </label>
                    <select name="timezone" required class="form-control time-zone time_zone time_zone_general_hospital ">
                        <option value=""> Select time-zone</option>
                        @foreach(timezone_identifiers_list() as $zone)
                            <option value="{{$zone}}"> {{$zone}}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-01 p-2 schedule">
                <div class="form-check">
                    <label class="form-check-label" for="schedule">
                        Schedule
                    </label>
                    <select name="schedule" required class="form-control  schedule_general_hospital">
                        <option value=""> Select Schedule</option>
                        @foreach(array_keys($schedule) as $key)
                            <option value="{{$key}}"> {{$schedule[$key]}}</option>
                        @endforeach
                    </select>


                </div>
            </div>
            <div class="col-01 p-2 day">
                <div class="form-check">
                    <label class="form-check-label day_label" for="Day">
                        Day
                    </label>
                    <select name="day" required class="form-control day_select day_general_hospital">
                        <option value=""> Select Schedule</option>

                    </select>


                </div>
            </div>
            <div class="col-01 p-2 time">
                <div class="form-check">
                    <label class="form-check-label " for="Time">
                        Time
                    </label>
                    <input name="time" type="time" value="{{ScheduleDetails('GENERAL_HOSPITAL')->time??''}}" required class="form-control ">


                </div>
            </div>


            <div class="col-12 p-2 ">
                <button type="submit" class="btn btn-sm btn-yarn">Run General Hospital Job</button>
            </div>
        </div>
    </form>
    <form class="form-group p-2 border border-dark" action="{{ route('admin.site.postHospitalSurveyJobs') }}"
          method="POST">
        @csrf
        <h4>Hospital</h4><br/>
        <input type="hidden" value="HOSPITAL" name="type_of">
        <div class="row  border-top-0 rounded-0">
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">

                        <label class="form-check-label" for="patient_infection_hospital">
                            Infection {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'disabled':''}} value="INFECTION" name="patient_category[]"
                                   id="patient_infection_hospital" {{!empty(ScheduleDetails('HOSPITAL','INFECTION'))?'checked': ''}}>
                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[INFECTION]" disabled required class=" time-zone form-control time_zone time_zone_hospital_infection" {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'disabled':''}} >
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[INFECTION]" disabled required class="form-control schedule_hospital_infection" {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[INFECTION]" disabled required class="form-control day_select day_select day_hospital_infection" {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[INFECTION]" disabled type="time" required class="form-control " {{!empty(checkIsActiveApi('HOSPITAL','INFECTION'))?'disabled':''}}  value="{{ScheduleDetails('HOSPITAL','INFECTION')->time??''}}">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_survey">
                            Patient Experience {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'disabled':''}} value="SURVEY" name="patient_category[]"
                                   id="patient_survey" {{!empty(ScheduleDetails('HOSPITAL','SURVEY'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[SURVEY]" disabled required class=" time-zone form-control time_zone time_zone_hospital_survey" {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[SURVEY]" disabled required class="form-control schedule_hospital_survey" {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[SURVEY]" disabled required class="form-control day_select day_hospital_survey" {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[SURVEY]" disabled type="time" required class="form-control " value="{{ScheduleDetails('HOSPITAL','SURVEY')->time??''}}" {{!empty(checkIsActiveApi('HOSPITAL','SURVEY'))?'disabled':''}} >


                        </div>
                    </div>

                </div>

            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_death_and_complications">
                            Death And Complications {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'disabled':''}} value="COMPLICATION_AND_DEATH"
                                   name="patient_category[]"
                                   id="patient_death_and_complications" {{!empty(ScheduleDetails('HOSPITAL','COMPLICATION_AND_DEATH'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[COMPLICATION_AND_DEATH]" disabled required class=" time-zone form-control time_zone time_zone_hospital_death_and_complication" {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[COMPLICATION_AND_DEATH]" disabled required class="form-control schedule_hospital_death_and_complication" {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[COMPLICATION_AND_DEATH]" disabled required class="form-control day_select day_hospital_death_and_complication" {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[COMPLICATION_AND_DEATH]" disabled type="time" required class="form-control " value="{{ScheduleDetails('HOSPITAL','COMPLICATION_AND_DEATH')->time??''}}" {{!empty(checkIsActiveApi('HOSPITAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_unplanned_visit">
                            Readmission {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'disabled':''}} value="UNPLANNED_VISITS"
                                   name="patient_category[]"
                                   id="patient_unplanned_visit" {{!empty(ScheduleDetails('HOSPITAL','UNPLANNED_VISITS'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[UNPLANNED_VISITS]" disabled required class=" time-zone form-control time_zone time_zone_hospital_unplanned_visits" {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[UNPLANNED_VISITS]" disabled required class="form-control schedule_hospital_unplanned_visits" {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[UNPLANNED_VISITS]" disabled required class="form-control day_select day_hospital_unplanned_visits" {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'disabled':''}}>
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[UNPLANNED_VISITS]" disabled type="time" value="{{ScheduleDetails('HOSPITAL','UNPLANNED_VISITS')->time??''}}" required class="form-control " {{!empty(checkIsActiveApi('HOSPITAL','UNPLANNED_VISITS'))?'disabled':''}}>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">

                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_speed_of_care_hospital">
                            Speed Of Care {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} value="TIMELY_AND_EFFECTIVE"
                                   name="patient_category[]" id="patient_speed_of_care_hospital" {{!empty(ScheduleDetails('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[TIMELY_AND_EFFECTIVE]" required disabled class=" time-zone form-control time_zone time_zone_hospital_timely_and_effective" {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[TIMELY_AND_EFFECTIVE]" disabled required class="form-control schedule_hospital_timely_and_effective" {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[TIMELY_AND_EFFECTIVE]" disabled required class="form-control day_select day_hospital_timely_and_effective" {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[TIMELY_AND_EFFECTIVE]" disabled type="time" required class="form-control " value="{{ScheduleDetails('HOSPITAL','TIMELY_AND_EFFECTIVE')->time??''}}" {{!empty(checkIsActiveApi('HOSPITAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}}>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2 ">
                <button type="submit" class="btn btn-sm btn-yarn">Run Hospital Job</button>
            </div>
        </div>
    </form>
    <form class="form-group p-2 border border-dark" action="{{ route('admin.site.postHospitalSurveyJobs') }}" method="POST">
        @csrf
        <h4>National</h4><br/>
        <input type="hidden" value="NATIONAL" name="type_of">
        <div class="row  border-top-0 rounded-0">
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">

                        <label class="form-check-label" for="patient_infection">
                            Infection {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'disabled':''}} value="INFECTION" name="patient_category[]"
                                   id="patient_infection" {{!empty(ScheduleDetails('NATIONAL','INFECTION'))?'checked': ''}}>
                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[INFECTION]" disabled required class=" time-zone form-control time_zone time_zone_national_infection" {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[INFECTION]" disabled required class="form-control schedule_national_infection" {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[INFECTION]" disabled required class="form-control day_national_infection day_select" {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[INFECTION]" disabled type="time" required class="form-control " value="{{ScheduleDetails('NATIONAL','INFECTION')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','INFECTION'))?'disabled':''}}>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_survey_hospital">
                            Patient Experience {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'disabled':''}} value="SURVEY" name="patient_category[]"
                                   id="patient_survey_hospital" {{!empty(ScheduleDetails('NATIONAL','SURVEY'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[SURVEY]" disabled required class="time-zone time_zone form-control time_zone_national_survey" {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[SURVEY]" disabled required class="form-control schedule_national_survey" {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[SURVEY]" disabled required class=" day_national_survey form-control day_select" {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[SURVEY]" disabled type="time" required class="form-control " value="{{ScheduleDetails('NATIONAL','SURVEY')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','SURVEY'))?'disabled':''}}>


                        </div>
                    </div>

                </div>

            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_survey_cancer">
                            Patient Experience Cancer {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'disabled':''}} value="SURVEY_CANCER" name="patient_category[]"
                                   id="patient_survey_cancer" {{!empty(ScheduleDetails('NATIONAL','SURVEY_CANCER'))?'checked': ''}}>
                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[SURVEY_CANCER]" disabled required class=" time-zone form-control time_zone   time_zone_national_survey_cancer" {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[SURVEY_CANCER]" disabled required class="form-control schedule_national_survey_cancer" {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[SURVEY_CANCER]" disabled required class="form-control day_select day_national_survey_cancer" {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[SURVEY_CANCER]" disabled type="time" required class="form-control " value="{{ScheduleDetails('NATIONAL','SURVEY_CANCER')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','SURVEY_CANCER'))?'disabled':''}}>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_death_and_complications_national">
                            Death And Complications {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'disabled':''}} value="COMPLICATION_AND_DEATH"
                                   name="patient_category[]" id="patient_death_and_complications_national" {{!empty(ScheduleDetails('NATIONAL','COMPLICATION_AND_DEATH'))?'checked': ''}}>
                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[COMPLICATION_AND_DEATH]" disabled required class=" time-zone form-control time_zone time_zone_national_death_and_complication" {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[COMPLICATION_AND_DEATH]" disabled required class="form-control schedule_national_death_and_complication" {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[COMPLICATION_AND_DEATH]" disabled required class="form-control day_select day_national_death_and_complication" {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[COMPLICATION_AND_DEATH]" disabled type="time" required class="form-control " value="{{ScheduleDetails('NATIONAL','COMPLICATION_AND_DEATH')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','COMPLICATION_AND_DEATH'))?'disabled':''}}>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_unplanned_visit_hospital">
                            Readmission {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'disabled':''}} value="UNPLANNED_VISITS"
                                   name="patient_category[]" id="patient_unplanned_visit_hospital" {{!empty(ScheduleDetails('NATIONAL','UNPLANNED_VISITS'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[UNPLANNED_VISITS]" disabled required class=" time-zone form-control time_zone time_zone_national_unplanned_visits" {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[UNPLANNED_VISITS]" disabled required class="form-control schedule_national_unplanned_visits" {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'disabled':''}}>
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[UNPLANNED_VISITS]" disabled required class="form-control day_select day_national_unplanned_visits" {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'disabled':''}}>
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[UNPLANNED_VISITS]" disabled type="time" value="{{ScheduleDetails('NATIONAL','UNPLANNED_VISITS')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','UNPLANNED_VISITS'))?'disabled':''}} required class="form-control ">


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">

                    <div class="col-04 p-2" style="min-width: 140px; max-width: 140px;">
                        <label class="form-check-label" for="patient_speed_of_care">
                            Speed Of Care {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'(In Process) ':''}}
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} value="TIMELY_AND_EFFECTIVE"
                                   name="patient_category[]" id="patient_speed_of_care" {{!empty(ScheduleDetails('NATIONAL','TIMELY_AND_EFFECTIVE'))?'checked': ''}}>

                        </div>
                    </div>
                    <div class="col-02 p-2 timezone">
                        <div class="form-check">
                            <label class="form-check-label" for="timezone">
                                Time Zone
                            </label>
                            <select name="timezone[TIMELY_AND_EFFECTIVE]" disabled required class=" time-zone form-control time_zone time_zone_national_timely_and_effective" {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}}>
                                <option value=""> Select time-zone</option>
                                @foreach(timezone_identifiers_list() as $zone)
                                    <option value="{{$zone}}"> {{$zone}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-02 p-2 schedule">
                        <div class="form-check">
                            <label class="form-check-label" for="schedule">
                                Schedule
                            </label>
                            <select name="schedule[TIMELY_AND_EFFECTIVE]" disabled required class="form-control schedule_national_timely_and_effective" {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>
                                @foreach(array_keys($schedule) as $key)
                                    <option value="{{$key}}"> {{$schedule[$key]}}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 day">
                        <div class="form-check">
                            <label class="form-check-label day_label" for="Day">
                                Day
                            </label>
                            <select  name="day[TIMELY_AND_EFFECTIVE]" disabled required class="form-control day_select day_national_timely_and_effective" {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} >
                                <option value=""> Select Schedule</option>

                            </select>


                        </div>
                    </div>
                    <div class="col-02 p-2 time">
                        <div class="form-check">
                            <label class="form-check-label " for="Time">
                                Time
                            </label>
                            <input name="time[TIMELY_AND_EFFECTIVE]" disabled type="time" required class="form-control " value="{{ScheduleDetails('NATIONAL','TIMELY_AND_EFFECTIVE')->time??''}}" {{!empty(checkIsActiveApi('NATIONAL','TIMELY_AND_EFFECTIVE'))?'disabled':''}} >


                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 p-2 ">
                <button type="submit" class="btn btn-sm btn-yarn">Run National Job</button>
            </div>
        </div>


    </form>


</div>


