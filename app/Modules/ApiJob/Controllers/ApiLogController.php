<?php namespace App\Modules\ApiJob\Controllers;

use App\Models\FootnodeCrosswalk;
use App\Models\Page;
use App\Models\Hospital;
use App\Models\ApiLog;
use App\Models\PatientComplicationAndDeath;
use App\Models\PatientInfection;
use App\Models\PatientSurvey;
use App\Models\PatientTimelyAndEffectiveCare;
use App\Models\PatientUnplannedVisit;
use App\Modules\User\Mail\FrontendUserMail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use DB;
use Illuminate\Http\Request;
use App\Modules\Page\Request\PageRequest;
use DataTables;
use phpDocumentor\Reflection\Types\self_;
use PHPUnit\Exception;

class ApiLogController extends \App\Http\Controllers\AdminController {
    protected $repo_service;
    public static $PROVIDER_DATA = [
        'GENERAL_HOSPITAL' => '63414a4c-1bbc-5182-80e2-b9317cb68c0b',
        'HOSPITAL'         => [
            'INFECTION'              => 'a4e87aa4-19d2-52d1-8af5-1be3dd701518',
            'SURVEY'                 => 'f99b6740-c40a-54df-a1be-6037ce02fb83',
            'COMPLICATION_AND_DEATH' => 'cf482657-c4cd-5967-baaf-bcf507790ed3',
            'UNPLANNED_VISITS'       => '40c642fb-beb6-5847-bc49-7c0a13a7ddcc',
            'TIMELY_AND_EFFECTIVE'   => '244fee4f-ed94-5289-945a-6571c2f20e23',
        ],
        'NATIONAL'         => [
            'INFECTION'              => '6dbe8d27-90a1-56d9-b2ad-4b8fd5bd1441',
            'SURVEY_CANCER'          => '6449766f-e87f-5b31-aa92-2a8f4ca8e697',
            'SURVEY'                 => '1ddcf94b-5ac7-549e-9c70-008a1389aa61',
            'COMPLICATION_AND_DEATH' => 'c1fa583e-603e-525b-aaf7-a22ea6f47240',
            'UNPLANNED_VISITS'       => '5ae5c99c-daa1-5eb3-8ca0-8cfe014f4edb',
            'TIMELY_AND_EFFECTIVE'   => '85f95744-7aa0-5a55-b1ea-2553a2eb1d54',
        ],
        'STATE'            => [
            'INFECTION'              => '706cae98-1b00-5fae-8ca3-71171fb86c0f',
            'SURVEY_CANCER'          => '82649f2a-55f6-5dc9-8845-16cdcbbc1ca7',
            'SURVEY'                 => '50d97e9f-33f1-5c79-b360-be9b3f0664b8',
            'COMPLICATION_AND_DEATH' => '5b08c77e-a8e1-5bd7-9519-c222a965ac35',
            'UNPLANNED_VISITS'       => 'd3b7bfac-a27c-5339-b49d-744a0452be81',
            'TIMELY_AND_EFFECTIVE'   => 'b98bdca1-b642-54f5-bc4d-4d8b21c0711d',
        ],
    ];
    public static $ONLY_MEASURE_ID_ALLOW = [
        'INFECTION'              => array( 'HAI_1_SIR', 'HAI_2_SIR', 'HAI_3_SIR', 'HAI_4_SIR', 'HAI_5_SIR', 'HAI_6_SIR' ),
        'SURVEY'                 => array(
            'H_COMP_1_STAR_RATING',
            'H_COMP_2_STAR_RATING',
            'H_COMP_3_STAR_RATING',
            'H_COMP_4_STAR_RATING',
            'H_COMP_5_STAR_RATING',
            'H_COMP_6_STAR_RATING',
            'H_COMP_7_STAR_RATING',
            'H_CLEAN_STAR_RATING',
            'H_QUIET_STAR_RATING',
            'H_HSP_RATING_STAR_RATING',
            'H_RECMND_STAR_RATING',
            'H_STAR_RATING'
        ),
        'COMPLICATION_AND_DEATH' => array( 'MORT_30_STK', 'COMP_HIP_KNEE', 'MORT_30_AMI', 'MORT_30_CABG', 'MORT_30_COPD', 'MORT_30_HF', 'MORT_30_PN', 'MORT_30_PN', 'PSI_03', 'PSI_04', 'PSI_05', 'PSI_06', 'PSI_08', 'PSI_09', 'PSI_10', 'PSI_11', 'PSI_12', 'PSI_13', 'PSI_14', 'PSI_15', 'PSI_90' ),
        'UNPLANNED_VISITS'       => array(
            'EDAC_30_AMI',
            'EDAC_30_HF',
            'EDAC_30_PN',
            'OP_32',
            'OP_35_ADM',
            'OP_35_ED',
            'OP_36',
            'READM_30_AMI',
            'READM_30_CABG',
            'READM_30_COPD',
            'READM_30_HF',
            'READM_30_HIP_KNEE',
            'READM_30_HOSP_WIDE',
            'READM_30_PN'
        ),
        'TIMELY_AND_EFFECTIVE'   => array(
            'EDV',
            'IMM_3',
            'OP_18b_NINETIETH',
            'OP_18b_LOW_MIN',
            'OP_18b_MEDIUM_MIN',
            'OP_18b',
            'OP_18b_HIGH_MIN',
            'OP_18b_VERY_HIGH_MIN',
            'OP_18c_NINETIETH',
            'OP_18c_LOW_MIN',
            'OP_18c_MEDIUM_MIN',
            'OP_18c',
            'OP_18c_HIGH_MIN',
            'OP_18c_VERY_HIGH_MIN',
            'OP_2',
            'OP_2_NINETIETH',
            'OP_22',
            'OP_22_NINETIETH',
            'OP_23',
            'OP_23_NINETIETH',
            'OP_29',
            'OP_29_NINETIETH',
            'OP_31',
            'OP_31_NINETIETH',
            'OP_33',
            'OP_33_NINETIETH',
            'OP_3b',
            'OP_3b_NINETIETH',
            'PC_1',
            'PC_1_NINETIETH',
            'PC_01',
            'PC_01_NINETIETH',
            'SEP_1',
            'SEP_1_NINETIETH',
            'SEP_SH_6HR',
            'SEP_SH_6HR_NINETIETH',
            'SEP_SH_6HR_SCORE',
            'SEP_SH_6HR_SCORE_NINETIETH',
            'SEV_SEP_3HR_SCORE',
            'SEV_SEP_3HR_SCORE_NINETIETH',
            'SEP_SH_3HR',
            'SEP_SH_3HR_NINETIETH',
            'SEV_SEP_3HR',
            'SEV_SEP_3HR_NINETIETH'
        ),
    ];
    public static $ONLY_MEASURE_ID_ALLOW_NATIONAL = [
        'INFECTION'              => array(
            'HAI_1_SIR',
            'HAI_2_SIR',
            'HAI_3_SIR',
            'HAI_4_SIR',
            'HAI_5_SIR',
            'HAI_6_SIR'
        ),
        'SURVEY_CANCER'          => array(
            'H_COMP_3_A_P',
            'H_COMP_3_U_P',
            'H_COMP_3_SN_P',
            'H_CALL_BUTTON_A_P',
            'H_CALL_BUTTON_U_P',
            'H_CALL_BUTTON_SN_P',
            'H_BATH_HELP_A_P',
            'H_BATH_HELP_U_P',
            'H_BATH_HELP_SN_P',
            'H_COMP_1_A_P',
            'H_HSP_RATING_9_10',
            'H_SIDE_EFFECTS_A_P',
            'H_SIDE_EFFECTS_U_P',
            'H_SIDE_EFFECTS_SN_P',
            'H_QUIET_HSP_A_P',
            'H_QUIET_HSP_U_P',
            'H_QUIET_HSP_SN_P',
            'H_NURSE_RESPECT_A_P',
            'H_NURSE_RESPECT_U_P',
            'H_NURSE_RESPECT_SN_P',
            'H_DOCTOR_RESPECT_A_P',
            'H_DOCTOR_RESPECT_U_P',
            'H_DOCTOR_RESPECT_SN_P',
            'H_HSP_RATING_0_6',
            'H_HSP_RATING_7_8',
            'H_RECMND_PY',
            'H_RECMND_DN',
            'H_RECMND_DY',
            'H_CLEAN_HSP_A_P',
            'H_CLEAN_HSP_U_P',
            'H_CLEAN_HSP_SN_P',
            'H_QUIET_HSP_A_P',
            'H_QUIET_HSP_U_P',
            'H_QUIET_HSP_SN_P',
            'H_COMP_7_A',
            'H_COMP_7_SA',
            'H_COMP_7_D_SD',
            'H_CT_PREFER_A',
            'H_CT_PREFER_SA',
            'H_CT_PREFER_D_SD',
            'H_CT_UNDER_A',
            'H_CT_UNDER_SA',
            'H_CT_UNDER_D_SD',
            'H_CT_MED_A',
            'H_CT_MED_SA',
            'H_CT_MED_D_SD',
            'H_SYMPTOMS_N_P',
            'H_SYMPTOMS_Y_P',
            'H_DISCH_HELP_N_P',
            'H_DISCH_HELP_Y_P',
            'H_COMP_6_N_P',
            'H_COMP_6_Y_P',
            'H_MED_FOR_A_P',
            'H_SIDE_EFFECT_A_P',
            'H_COMP_5_A_P',
            'H_COMP_1_U_P',
            'H_MED_FOR_U_P',
            'H_SIDE_EFFECT_U_P',
            'H_COMP_5_U_P',
            'H_COMP_1_SN_P',
            'H_MED_FOR_SN_P',
            'H_SIDE_EFFECT_SN_P',
            'H_COMP_5_SN_P',
            'H_COMP_2_A_P',
            'H_COMP_2_U_P',
            'H_COMP_2_SN_P',
            'H_NURSE_EXPLAIN_A_P',
            'H_NURSE_EXPLAIN_U_P',
            'H_NURSE_EXPLAIN_SN_P',
            'H_NURSE_LISTEN_A_P',
            'H_NURSE_LISTEN_U_P',
            'H_NURSE_LISTEN_SN_P',
            'H_NURSE_EXPLAIN_A_P_A_P',
            'H_NURSE_EXPLAIN_A_P_U_P',
            'H_NURSE_EXPLAIN_A_P_SN_P',
            'H_DOCTOR_EXPLAIN_A_P',
            'H_DOCTOR_EXPLAIN_U_P',
            'H_DOCTOR_EXPLAIN_SN_P',
            'H_DOCTOR_LISTEN_A_P',
            'H_DOCTOR_LISTEN_U_P',
            'H_DOCTOR_LISTEN_SN_P',
            'H_DOCTOR_EXPLAIN_A_P_A_P',
            'H_DOCTOR_EXPLAIN_A_P_U_P',
            'H_DOCTOR_EXPLAIN_A_P_SN_P',
            'H_COMP_1_STAR_RATING',
            'H_COMP_2_STAR_RATING',
            'H_COMP_3_STAR_RATING',
            'H_COMP_4_STAR_RATING',
            'H_COMP_5_STAR_RATING',
            'H_COMP_6_STAR_RATING',
            'H_COMP_7_STAR_RATING',
            'H_CLEAN_STAR_RATING',
            'H_QUIET_STAR_RATING',
            'H_HSP_RATING_STAR_RATING',
            'H_RECMND_STAR_RATING',
            'H_STAR_RATING'
        ),
        'SURVEY'                 => array(
            'H_COMP_3_A_P',
            'H_COMP_3_U_P',
            'H_COMP_3_SN_P',
            'H_CALL_BUTTON_A_P',
            'H_CALL_BUTTON_U_P',
            'H_CALL_BUTTON_SN_P',
            'H_BATH_HELP_A_P',
            'H_BATH_HELP_U_P',
            'H_BATH_HELP_SN_P',
            'H_COMP_1_A_P',
            'H_HSP_RATING_9_10',
            'H_QUIET_HSP_A_P',
            'H_QUIET_HSP_U_P',
            'H_HSP_RATING_9_10',
            'H_QUIET_HSP_SN_P',
            'H_COMP_1_A_P',
            'H_NURSE_RESPECT_A_P',
            'H_DOCTOR_RESPECT_A_P',
            'H_DOCTOR_RESPECT_U_P',
            'H_SIDE_EFFECTS_A_P',
            'H_SIDE_EFFECTS_U_P',
            'H_SIDE_EFFECTS_SN_P',
            'H_DOCTOR_RESPECT_SN_P',
            'H_NURSE_RESPECT_U_P',
            'H_NURSE_RESPECT_SN_P',
            'H_HSP_RATING_0_6',
            'H_HSP_RATING_7_8',
            'H_RECMND_PY',
            'H_RECMND_DN',
            'H_RECMND_DY',
            'H_CLEAN_HSP_A_P',
            'H_CLEAN_HSP_U_P',
            'H_CLEAN_HSP_SN_P',
            'H_QUIET_HSP_A_P',
            'H_QUIET_HSP_U_P',
            'H_QUIET_HSP_SN_P',
            'H_COMP_7_A',
            'H_COMP_7_SA',
            'H_COMP_7_D_SD',
            'H_CT_PREFER_A',
            'H_CT_PREFER_SA',
            'H_CT_PREFER_D_SD',
            'H_CT_UNDER_A',
            'H_CT_UNDER_SA',
            'H_CT_UNDER_D_SD',
            'H_CT_MED_A',
            'H_CT_MED_SA',
            'H_CT_MED_D_SD',
            'H_SYMPTOMS_N_P',
            'H_SYMPTOMS_Y_P',
            'H_DISCH_HELP_N_P',
            'H_DISCH_HELP_Y_P',
            'H_COMP_6_N_P',
            'H_COMP_6_Y_P',
            'H_MED_FOR_A_P',
            'H_SIDE_EFFECT_A_P',
            'H_COMP_5_A_P',
            'H_COMP_1_U_P',
            'H_MED_FOR_U_P',
            'H_SIDE_EFFECT_U_P',
            'H_COMP_5_U_P',
            'H_COMP_1_SN_P',
            'H_MED_FOR_SN_P',
            'H_SIDE_EFFECT_SN_P',
            'H_COMP_5_SN_P',
            'H_COMP_2_A_P',
            'H_COMP_2_U_P',
            'H_COMP_2_SN_P',
            'H_NURSE_EXPLAIN_A_P',
            'H_NURSE_EXPLAIN_U_P',
            'H_NURSE_EXPLAIN_SN_P',
            'H_NURSE_LISTEN_A_P',
            'H_NURSE_LISTEN_U_P',
            'H_NURSE_LISTEN_SN_P',
            'H_NURSE_EXPLAIN_A_P_A_P',
            'H_NURSE_EXPLAIN_A_P_U_P',
            'H_NURSE_EXPLAIN_A_P_SN_P',
            'H_DOCTOR_EXPLAIN_A_P',
            'H_DOCTOR_EXPLAIN_U_P',
            'H_DOCTOR_EXPLAIN_SN_P',
            'H_DOCTOR_LISTEN_A_P',
            'H_DOCTOR_LISTEN_U_P',
            'H_DOCTOR_LISTEN_SN_P',
            'H_DOCTOR_EXPLAIN_A_P_A_P',
            'H_DOCTOR_EXPLAIN_A_P_U_P',
            'H_DOCTOR_EXPLAIN_A_P_SN_P',
            'H_COMP_1_STAR_RATING',
            'H_COMP_2_STAR_RATING',
            'H_COMP_3_STAR_RATING',
            'H_COMP_4_STAR_RATING',
            'H_COMP_5_STAR_RATING',
            'H_COMP_6_STAR_RATING',
            'H_COMP_7_STAR_RATING',
            'H_CLEAN_STAR_RATING',
            'H_QUIET_STAR_RATING',
            'H_HSP_RATING_STAR_RATING',
            'H_RECMND_STAR_RATING',
            'H_STAR_RATING'
        ),
        'COMPLICATION_AND_DEATH' => array(
            'MORT_30_STK',
            'COMP_HIP_KNEE',
            'MORT_30_AMI',
            'MORT_30_CABG',
            'MORT_30_COPD',
            'MORT_30_HF',
            'MORT_30_PN',
            'MORT_30_PN',
            'PSI_03',
            'PSI_04',
            'PSI_05',
            'PSI_06',
            'PSI_08',
            'PSI_09',
            'PSI_10',
            'PSI_11',
            'PSI_12',
            'PSI_13',
            'PSI_14',
            'PSI_15',
            'PSI_90'
        ),
        'UNPLANNED_VISITS'       => array( 'EDAC_30_AMI', 'EDAC_30_HF', 'EDAC_30_PN', 'OP_32', 'OP_35_ADM', 'OP_35_ED', 'OP_36', 'READM_30_AMI', 'READM_30_CABG', 'READM_30_COPD', 'READM_30_HF', 'READM_30_HIP_KNEE', 'READM_30_HOSP_WIDE', 'READM_30_PN' ),
        'TIMELY_AND_EFFECTIVE'   => array(
            'EDV',
            'IMM_3',
            'OP_18b_NINETIETH',
            'OP_18b_LOW_MIN',
            'OP_18b_MEDIUM_MIN',
            'OP_18b',
            'OP_18b_HIGH_MIN',
            'OP_18b_VERY_HIGH_MIN',
            'OP_18c_NINETIETH',
            'OP_18c_LOW_MIN',
            'OP_18c_MEDIUM_MIN',
            'OP_18c',
            'OP_18c_HIGH_MIN',
            'OP_18c_VERY_HIGH_MIN',
            'OP_2',
            'OP_2_NINETIETH',
            'OP_22',
            'OP_22_NINETIETH',
            'OP_23',
            'OP_23_NINETIETH',
            'OP_29',
            'OP_29_NINETIETH',
            'OP_31',
            'OP_31_NINETIETH',
            'OP_33',
            'OP_33_NINETIETH',
            'OP_3b',
            'OP_3b_NINETIETH',
            'PC_1',
            'PC_1_NINETIETH',
            'PC_01',
            'PC_01_NINETIETH',
            'SEP_1',
            'SEP_1_NINETIETH',
            'SEP_SH_6HR',
            'SEP_SH_6HR_NINETIETH',
            'SEP_SH_6HR_SCORE',
            'SEP_SH_6HR_SCORE_NINETIETH',
            'SEV_SEP_3HR_SCORE',
            'SEV_SEP_3HR_SCORE_NINETIETH',
            'SEP_SH_3HR',
            'SEP_SH_3HR_NINETIETH',
            'SEV_SEP_3HR',
            'SEV_SEP_3HR_NINETIETH',
            'SEV_SEP_6HR',
            'SEV_SEP_6HR_NINETIETH'
        ),
    ];
    public static $FOOTNOTE_CROSSWALK = [
        '1'  => 'The number of cases/patients is too few to report.',
        '2'  => 'Data submitted were based on a sample of cases/patients.',
        '3'  => 'Results are based on a shorter time period than required.',
        '4'  => 'Data suppressed by CMS for one or more quarters.',
        '5'  => 'Results are not available for this reporting period.',
        '6'  => 'Fewer than 100 patients completed the HCAHPS survey. Use these scores with caution, as the number of surveys may be too low to reliably assess hospital performance.',
        '7'  => 'No cases met the criteria for this measure.',
        '8'  => 'The lower limit of the confidence interval cannot be calculated if the number of observed infections equals zero.',
        '9'  => 'No data are available from the state/territory for this reporting period.',
        '10' => 'Very few patients were eligible for the HCAHPS survey. The scores shown reflect fewer than 50 completed surveys. Use these scores with caution, as the number of surveys may be too low to reliably assess hospital performance.',
        '11' => 'There were discrepancies in the data collection process.',
        '12' => 'This measure does not apply to this hospital for this reporting period.',
        '13' => 'Results cannot be calculated for this reporting period.',
        '14' => 'The results for this state are combined with nearby states to protect confidentiality.',
        '15' => 'The number of cases/patients is too few to report a star rating.',
        '16' => 'There are too few measures or measure groups reported to calculate a star rating or measure group score.',
        '17' => 'This hospital\'s star rating only includes data reported on inpatient services.',
        '18' => 'This result is not based on performance data; the hospital did not submit data and did not submit an HAI exemption form.',
        '19' => 'Data are shown only for hospitals that participate in the Inpatient Quality Reporting (IQR) and Outpatient Quality Reporting (OQR) programs.',
        '20' => 'State and national averages do not include Veterans Health Administration (VHA) hospital data.',
        '21' => 'Patient survey results for Veterans Health Administration (VHA) hospitals do not represent official HCAHPS results and are not included in state and national averages.',
        '22' => 'Overall star ratings are not calculated for Veterans Health Administration (VHA) or Department of Defense (DoD) hospitals.',
        '23' => 'The data are based on claims that the hospital or facility submitted to CMS. The hospital or facility has reported discrepancies in their claims data.',
        '24' => 'Results for this Veterans Health Administration (VHA) hospital are combined with those from the VHA administrative parent hospital that manages all points of service.',
        '25' => 'State and national averages include Veterans Health Administration (VHA) hospital data.',
        '26' => 'State and national averages include Department of Defense (DoD) hospital data.',
        '27' => 'Patient survey results for Department of Defense (DoD) hospitals do not represent official HCAHPS results and are not included in state and national averages.',
        '28' => "The results are based on the hospital or facility's data submissions. CMS approved the hospital or facility's Extraordinary Circumstances Exception request suggesting that results may be impacted.",
        'a'  => 'Maryland hospitals are waived from receiving payment adjustments under the Program.',
        '*'  => 'For Maryland hospitals, no data are available to calculate a PSI 90 measure result; therefore, no performance decile or points are assigned for Domain 1 and the Total HAC score is dependent on the Domain 2 score.',
        '**' => 'This value was calculated using data reported by the hospital in compliance with the requirements outlined for this program and does not take into account information that became available at a later date.',
    ];
    public static $FOOTNOTE_CROSSWALK_KEY = [
        'key' => '88913452-1005-58cd-9b3f-60d18cc6da85'
    ];
    public static $TYPE = [
        '1' => 'GENERAL_HOSPITAL',
        '2' => 'HOSPITAL',
        '3' => 'NATIONAL',
        '4' => 'STATE',
    ];
    public static $CATEGORY_TYPE = [
        '1' => 'INFECTION',
        '2' => 'SURVEY_CANCER',
        '3' => 'SURVEY',
        '4' => 'COMPLICATION_AND_DEATH',
        '5' => 'UNPLANNED_VISITS',
        '6' => 'TIMELY_AND_EFFECTIVE',
    ];
    public $module = 'HospitalSurvey';

    public function __construct( \App\Modules\Page\Respository\PageRespository $page_respository ) {
        $this->repo_service = $page_respository;
    }

    public function ApiJob( $type_number, $category_type = null ) {
        $type = self::$TYPE[ $type_number ];
        if ( $category_type != null ) {
            $category_type = self::$CATEGORY_TYPE[ $category_type ];
        }
        $type = ucwords( $type );
        if ( $type_number != 1 ) {
            $request = ApiLog::latest()->where( 'is_active', 0 )->where( 'status', 'start' )->where( 'type_of', $type )->where( 'patient_category', $category_type )->first();
        } else {
            $request = ApiLog::latest()->where( 'is_active', 0 )->where( 'status', 'start' )->where( 'type_of', $type )->first();
        }
        if ( ! empty( $request ) ) {
            DB::beginTransaction();
            try {
                echo $request->type_of . ' </br>';
                echo $request->patient_category ?? '' . ' </br>';
                if ( $request->type_of == 'GENERAL_HOSPITAL' ) {
                    $fetch_api_key = self::$PROVIDER_DATA[ $request->type_of ];
                    $table         = new Hospital();
                    $query_api     = "[SELECT * FROM " . $fetch_api_key . "]";
                    $table_name    = 'hospitals';
                } else {
                    if ( $request->patient_category == "INFECTION" ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientInfection();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_infections';
                        $data_measure_id_allow          = self::$ONLY_MEASURE_ID_ALLOW[ $request->patient_category ];
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                    if ( $request->patient_category == 'SURVEY' ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientSurvey();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_survey';
                        $data_measure_id_allow          = self::$ONLY_MEASURE_ID_ALLOW[ $request->patient_category ];
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                    if ( $request->patient_category == 'SURVEY_CANCER' ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientSurvey();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_survey';
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                    if ( $request->patient_category == 'COMPLICATION_AND_DEATH' ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientComplicationAndDeath();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_complication_and_death';
                        $data_measure_id_allow          = self::$ONLY_MEASURE_ID_ALLOW[ $request->patient_category ];
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                    if ( $request->patient_category == 'UNPLANNED_VISITS' ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientUnplannedVisit();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_unplanned_visit';
                        $data_measure_id_allow          = self::$ONLY_MEASURE_ID_ALLOW[ $request->patient_category ];
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                    if ( $request->patient_category == 'TIMELY_AND_EFFECTIVE' ) {
                        $fetch_api_key                  = self::$PROVIDER_DATA[ $request->type_of ][ $request->patient_category ];
                        $table                          = new PatientTimelyAndEffectiveCare();
                        $query_api                      = "[SELECT * FROM " . $fetch_api_key . "]";
                        $table_name                     = 'patient_timely_and_effective_care';
                        $data_measure_id_allow          = self::$ONLY_MEASURE_ID_ALLOW[ $request->patient_category ];
                        $data_measure_id_allow_national = self::$ONLY_MEASURE_ID_ALLOW_NATIONAL[ $request->patient_category ];
                    }
                }
                $result     = curl_service_provider( $query_api, $request->offset );
                $count_data = count($result);
                if ( $count_data > 0 ) {
                    $collections = remove_space_bracket_api( $result );
                    $getFillable = $table->getFillable();
                    $insert_data = [];
                    $update_data = [];
                    $update_no   = 0;
                    $insert_no   = 0;
                    foreach ( $collections as &$collection ) {
                        if ( isset( $collection['start_date'] ) ) {
                            $collection['start_date'] = date( "Y-m-d", strtotime( $collection['start_date'] ) );
                        }
                        if ( isset( $collection['end_date'] ) ) {
                            $collection['end_date'] = date( "Y-m-d", strtotime( $collection['end_date'] ) );
                        }
                        if ( ! empty( $collection['answer_percent_footnote'] ) ) {
                            $array_footnote                        = explode( ', ', $collection['answer_percent_footnote'] );
                            $collection['answer_percent_footnote'] = '<ul>';
                            for ( $i = 0; $i < count( $array_footnote ); $i ++ ) {
                                $collection['answer_percent_footnote'] .= '<li>';
                                $collection['answer_percent_footnote'] .= array_key_exists( $array_footnote[ $i ], self::$FOOTNOTE_CROSSWALK ) ? self::$FOOTNOTE_CROSSWALK[ $array_footnote[ $i ] ] : $array_footnote[ $i ];
                                $collection['answer_percent_footnote'] .= '</li>';
                            }
                            $collection['answer_percent_footnote'] .= '</ul>';
                        }
                        if ( ! empty( $collection['footnote'] ) ) {
                            $array_footnote         = explode( ', ', $collection['footnote'] );
                            $collection['footnote'] = '<ul>';
                            for ( $i = 0; $i < count( $array_footnote ); $i ++ ) {
                                $collection['footnote'] .= '<li>';
                                $collection['footnote'] .= array_key_exists( $array_footnote[ $i ], self::$FOOTNOTE_CROSSWALK ) ? self::$FOOTNOTE_CROSSWALK[ $array_footnote[ $i ] ] : $array_footnote[ $i ];
                                $collection['footnote'] .= '</li>';
                            }
                            $collection['footnote'] .= '</ul>';
                        }
                        $collection['type_of']    = $request->type_of;
                        $collection['created_by'] = 2;
                        if ( $request->type_of == 'GENERAL_HOSPITAL' ) {


                            $hasValue = Hospital::where( 'facility_id', $collection['facility_id'] )->first();
                            if ( ! empty( $hasValue ) ) {

                                if ( $hasValue->lat == null ) {
                                    $geometry = $this->geometry( $collection["facility_name"] . ' ' . $collection["address"] . ' ' . $collection["county_name"] . ', ' . $collection["zip_code"] );
                                    if ( $geometry != false ) {
                                        $collection['lng'] = $geometry->lng;
                                        $collection['lat'] = $geometry->lat;
                                    }
                                }
                                $name_facility = str_replace( '&', 'AND', $collection['facility_name'] );
                                $collection['slug'] = Str::slug( $name_facility, '-');
                                $collection['updated_at'] = date( "Y-m-d h:i:sa" );
                                $update_data[ $update_no ] = Arr::only( $collection, $getFillable );
                                $update_no ++;
                            } else {
                                $slug = Hospital::where( 'facility_name', $collection['facility_name'] )->first();
                                if ( empty( $slug ) ) {
                                    $name_facility = str_replace( '&', 'AND', $collection['facility_name'] );
                                    $collection['slug'] = Str::slug( $name_facility, '-');
                                } else {
                                    $name_facility = str_replace( '&', 'AND', $collection['facility_name'] );
                                    $collection['slug'] = str_replace( ' ', '-',$name_facility) . '-' . $collection['facility_id'];

                                }
                                $geometry = $this->geometry( $collection["facility_name"] . ' ' . $collection["address"] . ' ' . $collection["county_name"] . ', ' . $collection["zip_code"] );
                                if ( $geometry != false ) {
                                    $collection['lng'] = $geometry->lng;
                                    $collection['lat'] = $geometry->lat;
                                }
                                $collection['updated_at'] = date( "Y-m-d h:i:sa" );
                                $collection['created_at'] = date( "Y-m-d h:i:sa" );
                                $insert_data[ $insert_no ] = Arr::only( $collection, $getFillable );
                                $insert_no ++;
                            }
                        } else {
                            if ( $request->type_of == 'HOSPITAL' ) {
                                if ( in_array( $collection['measure_id'], $data_measure_id_allow ) ) {
                                    $measure_ids = $table->where( 'facility_id', $collection['facility_id'] )->where( 'measure_id', $collection['measure_id'] )->first();
                                    if ( ! empty( $measure_ids ) ) {
                                        $collection['updated_at'] = date( "Y-m-d h:i:sa" );
                                        echo ( $collection['facility_id'] ) ?? 'Facility_id is not required' . 'Facility_id update   </br>';
                                        $update_data[ $update_no ] = Arr::only( $collection, $getFillable );
                                        $update_no ++;
                                    } else {
                                        $collection['created_at'] = date( "Y-m-d h:i:sa" );
                                        echo ( $collection['facility_id'] ) ?? 'Facility_id is not required' . 'Facility_id insert   </br>';
                                        $insert_data[ $insert_no ] = Arr::only( $collection, $getFillable );
                                        $insert_no ++;
                                    }
                                }
                            } else {
                                if ( in_array( $collection['measure_id'], $data_measure_id_allow_national ) ) {

                                    $measure_ids = $table->where( 'measure_id', $collection['measure_id'] )->where( 'type_of', $request->type_of )->first();
                                    if ( ! empty( $measure_ids ) ) {
                                        $key['updated_at'] = date( "Y-m-d h:i:sa" );
                                        echo $collection['measure_id'] . ' measure_id update   </br>';
                                        $update_data[ $update_no ] = Arr::only( $collection, $getFillable );
                                        $update_no ++;
                                    } else {
                                        $key['created_at'] = date( "Y-m-d h:i:sa" );
                                        echo $collection['measure_id'] . ' measure_id update   </br>';
                                        $insert_data[ $insert_no ] = Arr::only( $collection, $getFillable );
                                        $insert_no ++;
                                    }
                                }
                            }
                        }
                    }
                    if ( count( $update_data ) ) {
                        foreach ( $update_data as &$key ) {
                            $key['updated_at'] = date( "Y-m-d h:i:sa" );
                            if ( $key != null ) {
                                if ( $request->type_of == 'GENERAL_HOSPITAL' ) {
                                    //                                    echo ( $key['facility_id'] ) ?? 'Facility_id is not required' . 'Facility_id update </br>';
                                    $where = array( 'facility_id' => $key['facility_id'] );
                                } else if ( $request->type_of == 'HOSPITAL' ) {
                                    //                                    echo ( $key['facility_id'] ) ?? 'Facility_id is not required' . 'Facility_id update </br>';
                                    $where = array( 'facility_id' => $key['facility_id'], 'measure_id' => $key['measure_id'] );
                                } else {
                                    //                                    echo $key['measure_id'] . 'measure_id update   </br>';
                                    $where = array( 'type_of' => $request->type_of, 'measure_id' => $key['measure_id'] );
                                }
                                $update = $table->where( $where )->first();
                                $update->update( $key );
                            }
                        }
                    }
                    if ( count( $insert_data ) ) {
                        //                        dd($insert_data);
                        if ( $request->type_of == 'GENERAL_HOSPITAL' ) {

                            foreach ( $insert_data as $key ) {

                                $table->create( $key );
                            }
                        } else {
                            $table->insert( $insert_data );
                        }
                    }
                    $ApiLog_update         = ApiLog::find( $request->id );
                    $ApiLog_update->status = 'success';
                    $ApiLog_update->update();
                    $ApiLog_save                   = new ApiLog();
                    $ApiLog_save->type_of          = $request->type_of;
                    $ApiLog_save->patient_category = $request->patient_category;
                    $ApiLog_save->offset           = $request->offset + 50;
                    $ApiLog_save->status           = 'start';
                    $ApiLog_save->save();
                    echo 'success';
                } else {
                    $ApiLog_update         = ApiLog::find( $request->id );
                    $ApiLog_update->status = 'success';
                    $ApiLog_update->update();
                    $ApiLog_save                   = new ApiLog();
                    $ApiLog_save->type_of          = $request->type_of;
                    $ApiLog_save->patient_category = $request->patient_category;
                    $ApiLog_save->offset           = 0;
                    $ApiLog_save->is_active        = 1;
                    $ApiLog_save->status           = 'stop';
                    $ApiLog_save->save();
                    $ApiLog_active_status = ApiLog::where( 'type_of', $request->type_of )->where( 'patient_category', $request->patient_category )->update( [ 'is_active' => 1 ] );
                    echo 'success';
                }
                DB::commit();
                //database backup start
                //                $mysqlHostName       = env( 'DB_HOST' );
                //                $mysqlUserName       = env( 'DB_USERNAME' );
                //                $mysqlPassword       = env( 'DB_PASSWORD' );
                //                $DbName              = env( 'DB_DATABASE' );
                //                $table               = $table_name;
                //                $connect             = new \PDO( "mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array( \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'" ) );
                //                $get_all_table_query = "SHOW TABLES";
                //                $statement           = $connect->prepare( $get_all_table_query );
                //                $statement->execute();
                //                $result           = $statement->fetchAll();
                //                $output           = '';
                //                $show_table_query = "SHOW CREATE TABLE " . $table . "";
                //                $statement        = $connect->prepare( $show_table_query );
                //                $statement->execute();
                //                $show_table_result = $statement->fetchAll();
                //                foreach ( $show_table_result as $show_table_row ) {
                //                    $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
                //                }
                //                $select_query = "SELECT * FROM " . $table . "";
                //                $statement    = $connect->prepare( $select_query );
                //                $statement->execute();
                //                $total_row = $statement->rowCount();
                //                for ( $count = 0; $count < $total_row; $count ++ ) {
                //                    $single_result      = $statement->fetch( \PDO::FETCH_ASSOC );
                //                    $table_column_array = array_keys( $single_result );
                //                    $table_value_array  = array_values( $single_result );
                //                    $output             .= "\nINSERT INTO $table (";
                //                    $output             .= "" . implode( ", ", $table_column_array ) . ") VALUES (";
                //                    $output             .= "'" . implode( "','", $table_value_array ) . "');\n";
                //                }
                //                $file_name   = 'database_backup/' . $table_name . '-' . date( 'd-m-y-H-i-s-A' ) . '.sql';
                //                $file_handle = fopen( $file_name, 'w+' );
                //                fwrite( $file_handle, $output );
                //                fclose( $file_handle );
                //database backup end
            } catch( \Exception $e ) {
                DB::rollback();
                $ApiLog_update              = ApiLog::find( $request->id );
                $ApiLog_update->count_error = $request->count_error + 1;
                $ApiLog_update->update();
                if ( $ApiLog_update->count_error == 2 ) {
                    $ApiLog_save                   = new ApiLog();
                    $ApiLog_save->type_of          = $request->type_of;
                    $ApiLog_save->patient_category = $request->patient_category ?: null;
                    $ApiLog_save->offset           = $request->offset;
                    $ApiLog_save->status           = 'stop';
                    $ApiLog_save->error_message    = $e;
                    $ApiLog_save->save();
                    $ApiLog_active_status = ApiLog::where( 'type_of', $request->type_of )->where( 'patient_category', $request->patient_category ?: null )->update( [ 'is_active' => 1 ] );
                } else {
                    $ApiLog_save                   = new ApiLog();
                    $ApiLog_save->type_of          = $request->type_of;
                    $ApiLog_save->patient_category = $request->patient_category ?: null;
                    $ApiLog_save->offset           = $request->offset;
                    $ApiLog_save->status           = 'error';
                    $ApiLog_save->error_message    = $e;
                    $ApiLog_save->save();
                }
                echo '<br>';
                echo 'error';
            }
        }
    }

    public function geometry( $location ) {
        try {

            $array_parameter = [
                'key'     => 'AIzaSyCe-36GFHdejJC2VVLYiHcfZBI9fBi37Tg',
                'address' => $location,
            ];
            $queryString     = http_build_query( $array_parameter );
            $curl            = curl_init( sprintf( '%s?%s', 'https://maps.google.com/maps/api/geocode/json', $queryString ) );
            curl_setopt_array( $curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ) );
            $response = curl_exec( $curl );
            curl_close( $curl );
            $response = json_decode( $response );
            if ( isset( $response->results[0]->geometry->location ) ) {
                $geometry = $response->results[0]->geometry->location;
            } else {

                return false;
            }
            if ( $geometry->lat != 0 or $geometry->lat != null ) {
                return $geometry;
            } else {
                return false;
            }
        } catch( Exception $e ) {

            print_r( $e );

            return false;
        }
    }

    public function getFootnodeCrosswalk(){

        $query ='[SELECT * FROM '.self::$FOOTNOTE_CROSSWALK_KEY['key'].']';

        $api_url = "https://data.cms.gov/provider-data/api/1/datastore/sql?query=" . urlencode($query . '[LIMIT 100]');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $array = json_decode($result, true);
        $result = remove_space_bracket_api($array);
        for ($i=0;$i<count($result);$i++){
            $footnode = FootnodeCrosswalk::where('footnote',$result[$i]['footnote'])->first();
            if($footnode){
                $footnode_data = FootnodeCrosswalk::find($footnode->id);
            }else{
                $footnode_data = new FootnodeCrosswalk();
            }
            $footnode_data->footnote = $result[$i]['footnote'];
            $footnode_data->footnote_text = $result[$i]['footnote_text'];
            $footnode_data->save();

        }
        print_r($result) ;

    }

}
