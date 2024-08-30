<table id="infection_table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Measure id</th>
        <th>Measure Name</th>
        <th>Compared To National</th>
        <th>Score</th>
        <th>Footnote</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($patient_infection as $infection_key)
        <tr>
            <td>{{$infection_key->measure_id ?: '-'}}</td>
            <td>{{$infection_key->measure_name ?: '-'}}</td>
            <td>{{$infection_key->compared_to_national ?: '-'}}</td>
            <td>{{$infection_key->score ?: '-'}}</td>
            <td>{{$infection_key->footnote ?: '-'}}</td>
            <td>{{$infection_key->start_date ?: '-'}}</td>
            <td>{{$infection_key->end_date ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
