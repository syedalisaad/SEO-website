<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientUnplannedVisit extends Model {
    use HasFactory;
    protected $table = 'patient_unplanned_visit';
    protected $fillable = [
        'facility_id',
        'facility_name',
        'hospital_id',
        'measure_id',
        'measure_name',
        'score',
        'number_of_patients',
        'number_of_patients_returned',
        'number_of_hospitals_fewer',
        'number_of_hospitals_average',
        'number_of_hospitals_more',
        'number_of_hospitals_to_small',
        'footnote',
        'compared_to_national',
        'type_of',
        'start_date',
        'end_date',
        'number_of_hospitals_worse',
        'number_of_hospitals_same',
        'number_of_hospitals_better',
        'national_rate',
        'number_of_hospitals_too_small',
        'number_of_hospitals_too_few',
    ];

    public function getScoreClassAttribute() {
        $compared_to_national = trim( $this->compared_to_national );
        if ( in_array( $this->measure_id, array( 'EDAC_30_AMI', 'EDAC_30_HF', 'EDAC_30_PN' ) ) ) {
            if ( $compared_to_national == 'Average Days per 100 Discharges' ) {
                return "yellow";
            } else if ( $compared_to_national == 'More Days Than Average per 100 Discharges' ) {
                return "red";
            } else if ( $compared_to_national == 'Fewer Days Than Average per 100 Discharges' ) {
                return "green";
            } else {
                return "white";
            }
        } else if ( in_array( $this->measure_id, array( 'OP_36' ) ) ) {
            if ( $compared_to_national == 'No Different than expected' ) {
                return "yellow";
            } else if ( $compared_to_national == 'Worse than expected' ) {
                return "red";
            } else if ( $compared_to_national == 'Better than expected' ) {
                return "green";
            } else {
                return "white";
            }
        } else {
            if ( $compared_to_national == 'No Different Than the National Rate' || $compared_to_national == 'No Different Than the National Rate' ) {
                return "yellow";
            } else if ( $compared_to_national == 'Worse Than National Rate' || $compared_to_national == 'Worse Than the National Rate'  ) {
                return "red";
            } else if ( $compared_to_national == 'Better Than National Rate' || $compared_to_national == 'Better Than the National Rate'  ) {
                return "green";
            } else {
                return "white";
            }
        }
    }

    public function getFootnoteScoreNotAvailableAttribute(){
        return $this->score!='Not Available'?$this->footnote:"<ul><li>Results are not available for this reporting period.</li></ul>";
    }
}
