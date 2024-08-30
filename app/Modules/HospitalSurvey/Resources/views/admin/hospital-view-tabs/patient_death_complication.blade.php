
<table id="unplanned_visit_table" class="display table table-striped table-bordered">
    <thead>
    <tr>
        <th>Measure id  </th>
        <th>Measure Name</th>
        <th>Compared To National</th>
        <th>score</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($patient_death_complication as $death_complication_key)
        <tr>
            <td>{{$death_complication_key->measure_id ?: '-'}}</td>
            <td>{{$death_complication_key->measure_name ?: '-'}}</td>
            <td>{{$death_complication_key->compared_to_national ?: '-'}}</td>
            <td>{{$death_complication_key->score ?: '-'}}</td>
            <td>{{$death_complication_key->start_date ?: '-'}}</td>
            <td>{{$death_complication_key->end_date ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>






