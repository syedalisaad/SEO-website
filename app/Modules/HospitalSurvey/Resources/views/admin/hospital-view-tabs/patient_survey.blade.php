
<table id="survey_table" class="display table table-striped table-bordered">
    <thead>
    <tr>
        <th>Measure id </th>
        <th>Measure Name</th>
        <th>Star Rating</th>
        <th>Question</th>
        <th>Answer Description</th>
        <th>Answer Percent</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($patient_survey as $survey_key)
        <tr>
            <td>{{$survey_key->measure_id ?: '-'}}</td>
            <td>{{$survey_key->measure_name ?: '-'}}</td>
            <td>{{$survey_key->patient_survey_star_rating ?: '-'}}</td>
            <td>{{$survey_key->question ?: '-'}}</td>
            <td>{{$survey_key->answer_description ?: '-'}}</td>
            <td>{{$survey_key->answer_percent ?: '-'}}</td>
            <td>{{$survey_key->start_date ?: '-'}}</td>
            <td>{{$survey_key->end_date ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>






