<?php namespace App\Modules\HospitalSurvey\Respository;

use App\Models\ApiLog;
use App\Models\Schedule;

use DB;

class HospitalSurveyRespository
{
    /*
    * Hospitals - Create Or Update
    *
    */
    public function forApiHospitalCreateOrUpdate($request)
    {
        if(is_array($request->patient_category) && count($request->patient_category))
        {
            for($i=0;$i<count($request->patient_category);$i++)
            {
                if(isset($request->timezone[$request->patient_category[$i]]))
                {
                    $schedule = Schedule::updateOrCreate(
                        ['type_of' =>  $request->type_of, 'patient_category' =>  $request->patient_category[$i]],
                        ['timezone' => $request->timezone[$request->patient_category[$i]]?? null, 'schedule' =>$request->schedule[$request->patient_category[$i]]?? null, 'day' => $request->day[$request->patient_category[$i]]?? null, 'time' => $request->time[$request->patient_category[$i]]?? null]
                    );
                }
            }
        }
        else
        {
            $schedule = Schedule::updateOrCreate(
                ['type_of' =>  $request->type_of, 'patient_category' =>  null],
                ['timezone' => $request->timezone??null, 'schedule' => $request->schedule??null, 'day' => $request->day??null, 'time' => $request->time??null]
            );
        }

        return true;
    }
}
