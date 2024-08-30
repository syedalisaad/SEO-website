
<table id="timely_effective_care_table" class="display table table-striped table-bordered">
    <thead>
    <tr>
        <th>Measure id  </th>
        <th>Measure Name</th>
        <th>score</th>
        <th>Footnote</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($patient_timely_effective_care  as $timely_effective_care_key)
        <tr>
            <td>{{$timely_effective_care_key->measure_id ?: '-'}}</td>
            <td>{{$timely_effective_care_key->measure_name ?: '-'}}</td>
            <td>{{$timely_effective_care_key->score ?: '-'}}</td>
            <td>{{$timely_effective_care_key->footnote ?: '-'}}</td>
            <td>{{$timely_effective_care_key->start_date ?: '-'}}</td>
            <td>{{$timely_effective_care_key->end_date ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>






