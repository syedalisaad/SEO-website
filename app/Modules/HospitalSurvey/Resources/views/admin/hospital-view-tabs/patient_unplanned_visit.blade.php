
<table id="death_complication_table" class="display table table-striped table-bordered">
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
    @foreach($patient_unplanned_visit  as $unlanned_visit_key)
        <tr>
            <td>{{$unlanned_visit_key->measure_id ?: '-'}}</td>
            <td>{{$unlanned_visit_key->measure_name ?: '-'}}</td>
            <td>{{$unlanned_visit_key->score ?: '-'}}</td>
            <td>{{$unlanned_visit_key->footnote ?: '-'}}</td>
            <td>{{$unlanned_visit_key->start_date ?: '-'}}</td>
            <td>{{$unlanned_visit_key->end_date ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>






