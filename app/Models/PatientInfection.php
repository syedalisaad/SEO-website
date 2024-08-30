<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInfection extends Model
{
    use HasFactory;

    protected $table = 'patient_infections';

    protected $fillable = [
        'facility_id',
        'facility_name',
        'hospital_id',
        'measure_id',
        'measure_name',
        'compared_to_national',
        'score',
        'footnote',
        'type_of',
        'start_date',
        'end_date',

    ];

    public function getScoreClassAttribute()
    {
        switch ( trim($this->compared_to_national) )
        {
            case 'Better than the National Benchmark':
                return 'greenbtn';
            break;
            case 'No Different than National Benchmark':
                return 'yellowbtn';
            break;
            case 'Worse than the National Benchmark':
                return 'redbtn';
            break;
            default:
                return 'silverbtn';
            break;
        }
    }

    public function getFootnoteScoreNotAvailableAttribute(){
        return $this->score!='Not Available'?$this->footnote:"<ul><li>Results are not available for this reporting period.</li></ul>";
    }
}
