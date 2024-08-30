<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model {
    use HasFactory;

    static public $storage_disk = 'hospitals';
    protected $fillable = [
        'facility_id',
        'facility_name',
        'short_desc',
        'description',
        'phone_number',
        'address',
        'county_name',
        'state',
        'city',
        'zip_code',
        'hospital_type',
        'hospital_ownership',
        'emergency_services',
        'hospital_overall_rating',
        'ref_url',
        'extras',
        'is_active',
        'slug',
        'is_api',
        'source_image',
        'seo_metadata',
        'created_by',
        'lat',
        'lng',
        'created_at',
        'updated_at',
    ];
    protected $appends = [
        'formatted_address'
    ];

    public function scopeIsActive( $query ) {
        return $query->where( 'is_active', 1 );
    }

    public function getFormattedAddressAttribute() {
        return $this->address . ', ' . $this->city . ', '. $this->state . ' ' . $this->zip_code;
    }

    public static function getLists() {
        return self::all()->pluck( 'facility_name', 'id' )->toArray();
    }

    public function infection_patients() {
        return $this->hasMany( PatientInfection::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' );
    }

    public function survy_patients() {
        return $this->hasMany( PatientSurvey::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' );
    }

    public function death_pateints() {
        return $this->hasMany( PatientComplicationAndDeath::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' )->where( 'measure_name', 'like', '%death%' );
    }

    public function complication_pateints() {
        return $this->hasMany( PatientComplicationAndDeath::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' )->where( 'measure_name', '!=', '%death%' );
    }

    public function readmission_compared_to_patients() {
        return $this->hasMany( PatientUnplannedVisit::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' );
    }

    public function readmission_score_patients() {
        return $this->hasMany( PatientUnplannedVisit::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' );
    }

    public function summary_patients() {
        return $this->hasOne( PatientSurvey::class, 'facility_id', 'facility_id' )->where( [ 'type_of' => 'HOSPITAL', 'measure_id' => 'H_STAR_RATING' ] );
    }

    public function speed_of_care_hospitals() {
        return $this->hasMany( PatientTimelyAndEffectiveCare::class, 'facility_id', 'facility_id' )->where( 'type_of', 'HOSPITAL' );
    }

    public function speed_of_care_nationals() {
        return $this->hasMany( PatientTimelyAndEffectiveCare::class, 'facility_id', 'facility_id' )->where( 'type_of', 'NATIONAL' );
    }

    public function hospital_info() {
        return $this->hasOne( UserHospitalInfo::class, 'hospital_id', 'id' );
    }

    public function getIndustryLeaderAttribute()
    {
        if ( $this->summary_patients  && $this->hospital_overall_rating == 5 && $this->summary_patients->patient_survey_star_rating == 5 ) {
            return 1;
        }

        return 0;
    }
}
