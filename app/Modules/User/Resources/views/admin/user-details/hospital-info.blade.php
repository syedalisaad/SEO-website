<p class="lead font-weight-bold ">Hospital Information</p>

<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th width="20%">Name</th>
                <td>{{ $data->detail->HospitalDetail ? $data->detail->HospitalDetail->facility_name : '-' }}</td>
            </tr>
            <tr>
                <th width="20%">Phone Number</th>
                <td>{{ $data->detail->HospitalDetail ? $data->detail->HospitalDetail->phone_number : '-' }}</td>
            </tr>
            <tr>
                <th width="20%">Address</th>
                <td>{{ $data->detail->HospitalDetail ? $data->detail->HospitalDetail->address : '-' }}</td>
            </tr>
            <tr>
                <th width="20%">Reference URL</th>
                <td>{{ $data->detail->HospitalDetail ? $data->detail->HospitalDetail->ref_url : '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>
