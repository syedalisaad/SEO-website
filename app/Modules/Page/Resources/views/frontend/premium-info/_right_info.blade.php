<ul>
    <li>
        <h5>Serving Patients in:</h5>
        <p>{{$hospital->county_name}}</p>
    </li>
    <li>
        <h5>Healthcare workers given influenza vaccination:</h5>
        <p>{{$healthcare_vaccination->score??'-'}}</p>
    </li>
    <li>
        <h5>Type of Hospital:</h5>
        <p>{{$hospital->hospital_type}}</p>
    </li>
    <li>
        <h5>Emergency department volume:</h5>
        <p>{{$healthcare_volume->score??'-'}}</p>
    </li>
    <li>
        <h5>Emergency Services:</h5>
        <p>{{$hospital->emergency_services}}</p>
    </li>
</ul>
