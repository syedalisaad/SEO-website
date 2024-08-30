<div class="row moreinfo">
    <div class="col-md-12">
        <h3>Click below for more Information on this Hospital</h3>
    </div>

    <div class="col-md-3">
        <div class="sbox">
            <div class="img">
                <a href="{{route(front_route('page.hospital.infection'),last(request()->segments()))}}">
                <img src="{{asset(front_asset('images/infection.webp'))}}" alt="infection">
                </a>
            </div>
            <h4>Infection</h4>
            <p>A list of different infections along with infection related conditions being measured at each reporting hospital.</p>
            <a href="{{route(front_route('page.hospital.infection'),last(request()->segments()))}}">View
                More <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sbox">
            <div class="img">
                <a href="{{route(front_route('page.hospital.survey'),last(request()->segments()))}}">
                <img src="{{asset(front_asset('images/patient.webp'))}}" alt="patient">
                </a>
            </div>
            <h4>Patient Experience</h4>
            <p>The combined scores of all the measured hospitals to show the national scores for patient surveys.</p>
            <a href="{{route(front_route('page.hospital.survey'),last(request()->segments()))}}">View More
                <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sbox">
            <div class="img">
                <a href="{{route(front_route('page.hospital.death_and_complication'),last(request()->segments()))}}">
                <img src="{{asset(front_asset('images/complication.webp'))}}" alt="complication">
                </a>
            </div>
            <h4>Death & Complication</h4>
            <p>A breakdown for each category of the number of hospitals who scored below average, at average, or above average in the nation.</p>
            <a href="{{route(front_route('page.hospital.death_and_complication'),last(request()->segments()))}}">View
                More <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sbox">
            <div class="img">
                <a href="{{route(front_route('page.hospital.readmission'),last(request()->segments()))}}">
                <img src="{{asset(front_asset('images/readmission.webp'))}}" alt="readmission">
                </a>
            </div>
            <h4>Readmission</h4>
            <p>A high level view of the number of hospitals who have patients returning for additional care.</p>
            <a href="{{route(front_route('page.hospital.readmission'),last(request()->segments()))}}">View
                More <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="sbox">
            <div class="img">
                <a href="{{route(front_route('page.hospital.speed-of-care'),last(request()->segments()))}}">
                <img src="{{asset(front_asset('images/care.webp'))}}" alt="care">
                </a>
            </div>
            <h4>Speed of Care</h4>
            <p>A list of the situations being measured, and the associated speed of those measures.</p>
            <a href="{{route(front_route('page.hospital.speed-of-care'),last(request()->segments()))}}">View
                More <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>
</div>
