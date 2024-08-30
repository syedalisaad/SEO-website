<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTimelyAndEffectiveCare extends Model
{
    use HasFactory;

    static public $MEASURE_ID = [
        'HOSPITAL' => [
            'OP_18b'      => 'OP_18b',
            'OP_18C'      => 'OP_18c',
            'OP_2'        => 'OP_2',
            'OP_22'       => 'OP_22',
            'OP_23'       => 'OP_23',
            'OP_29'       => 'OP_29',
            'OP_31'       => 'OP_31',
            'OP_33'       => 'OP_33',
            'OP_3B'       => 'OP_3b',
            'PC_01'       => 'PC_01',
            'SEP_1'       => 'SEP_1',
            'SEP_SH_3HR'  => 'SEP_SH_3HR',
            'SEP_SH_6HR'  => 'SEP_SH_6HR',
            'SEV_SEP_3HR' => 'SEV_SEP_3HR',
        ],
        'NATIONAL' => [
            'OP_18b_MEDIUM_MIN'     => 'OP_18b_MEDIUM_MIN',
            'OP_18B_NINETIETH'      => 'OP_18b_NINETIETH',
            'OP_18C_MEDIUM_MIN'     => 'OP_18c_MEDIUM_MIN',
            'OP_18C_NINETIETH'      => 'OP_18c_NINETIETH',
            'OP_2'                  => 'OP_2',
            'OP_2_NINETIETH'        => 'OP_2_NINETIETH',
            'OP_22'                 => 'OP_22',
            'OP_22_NINETIETH'       => 'OP_22_NINETIETH',
            'OP_23'                 => 'OP_23',
            'OP_23_NINETIETH'       => 'OP_23_NINETIETH',
            'OP_29'                 => 'OP_29',
            'OP_29_NINETIETH'       => 'OP_29_NINETIETH',
            'OP_31'                 => 'OP_31',
            'OP_31_NINETIETH'       => 'OP_31_NINETIETH',
            'OP_33'                 => 'OP_33',
            'OP_33_NINETIETH'       => 'OP_33_NINETIETH',
            'OP_3B'                 => 'OP_3b',
            'OP_3B_NINETIETH'       => 'OP_3b_NINETIETH',
            'PC_01'                 => 'PC_01',
            'PC_01_NINETIETH'       => 'PC_01_NINETIETH',
            'SEP_1'                 => 'SEP_1',
            'SEP_1_NINETIETH'       => 'SEP_1_NINETIETH',
            'SEP_SH_3HR'            => 'SEP_SH_3HR',
            'SEP_SH_3HR_NINETIETH'  => 'SEP_SH_3HR_NINETIETH',
            'SEP_SH_6HR'            => 'SEP_SH_6HR',
            'SEP_SH_6HR_NINETIETH'  => 'SEP_SH_6HR_NINETIETH',
            'SEV_SEP_3HR'           => 'SEV_SEP_3HR',
            'SEV_SEP_3HR_NINETIETH' => 'SEV_SEP_3HR_NINETIETH',
        ]
    ];

    protected $table = 'patient_timely_and_effective_care';

    protected $fillable = [
        'facility_id',
        'facility_name',
        'hospital_id',
        'measure_id',
        'measure_name',
        'score',
        'footnote',
        'type_of',
        'start_date',
        'end_date',
    ];

    public function getScoreAverageAttribute() {
        return is_numeric($this->score) ? $this->score.'%': 'Not Available';
    }

    public function getScoreAverageClassAttribute() {
        return (!is_numeric($this->score) ? '' : 'bluebtn');
    }

    public function getFootnoteScoreNotAvailableAttribute(){
        return $this->score!='Not Available'?$this->footnote:"<ul><li>Results are not available for this reporting period.</li></ul>";
    }
}
