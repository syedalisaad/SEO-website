<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientComplicationAndDeath extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'facility_name',
        'measure_id',
        'measure_name',
        'compared_to_national',
        'score',
        'national_number',
        'type_of',
        'number_of_hospitals_worse',
        'number_of_hospitals_same',
        'number_of_hospitals_better',
        'number_of_hospitals_few',
        'number_of_hospitals_too_few',
        'national_rate',
        'footnote',
        'start_date',
        'end_date',
    ];
    protected $table = 'patient_complication_and_death';

    public function getScoreClassAttribute()
    {
        if ( $this->compared_to_national == 'Not Available' || $this->compared_to_national == 'Number of Cases Too Small' ) {
            return'btn silverbtn';
        } else if ( $this->compared_to_national == 'Better Than the National Rate' || $this->compared_to_national == 'Better Than the National Value' ) {
            return'btn greenbtn';
        } else if ( $this->compared_to_national == 'No Different Than the National Rate' || $this->compared_to_national == 'No Different Than the National Value' ) {
            return'btn yellowbtn';
        } else if ( $this->compared_to_national == 'Worse Than the National Rate' || $this->patient_survey_star_rating == 'Worse Than the National Value' ) {
            return'btn redbtn';
        } else {
            return'btn silverbtn';
        }
    }

    public function getFootnoteScoreNotAvailableAttribute(){
        return $this->score!='Not Available'?$this->footnote:"<ul><li>Results are not available for this reporting period.</li></ul>";
    }
}
