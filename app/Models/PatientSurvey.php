<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSurvey extends Model
{
    use HasFactory;

    protected $table = 'patient_survey';
    protected $fillable = [
        'facility_id',
        'facility_name',
        'measure_id',
        'measure_name',
        'patient_survey_star_rating',
        'patient_survey_star_rating_footnote',
        'score',
        'question',
        'answer_description',
        'answer_percent',
        'answer_percent_footnote',
        'start_date',
        'end_date',
        'type_of',
    ];

    public function getStarClassAttribute()
    {
        switch ( $this->patient_survey_star_rating )
        {
            case 1:
                return 'redstar';
            break;
            case 2:
                return 'orangestar';
            break;
            case 3:
                return 'yellowstar';
            break;
            case 4:
                return 'lemonstar';
            break;
            case 5:
                return 'greenstar';
            break;
            default:
                return 'silverbtn';
            break;
        }
    }

    public function getFootnoteScoreNotAvailableAttribute(){
        return $this->score!='Not Available'?$this->answer_percent_footnote:"<ul><li>Results are not available for this reporting period.</li></ul>";
    }
}
