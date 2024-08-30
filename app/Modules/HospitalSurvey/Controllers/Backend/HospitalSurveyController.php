<?php namespace App\Modules\HospitalSurvey\Controllers\Backend;

use App\Models\Hospital;
use App\Models\Order;
use App\Models\PatientComplicationAndDeath;
use App\Models\PatientInfection;
use App\Models\PatientSurvey;
use App\Models\PatientTimelyAndEffectiveCare;
use App\Models\PatientUnplannedVisit;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserHospitalInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use App\Support\Traits\StorageableTrait;
use App\Support\Traits\UploadableTrait;

class HospitalSurveyController extends \App\Http\Controllers\AdminController {
    protected $repo_service;
    public $module = 'HospitalSurvey';
    use StorageableTrait,UploadableTrait;

    public function __construct( \App\Modules\HospitalSurvey\Respository\HospitalSurveyRespository $hospital_survey_respository ) {
        $this->repo_service = $hospital_survey_respository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function getManage() {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$PAGE['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'manage', $this->module ) );
    }

    public function ajaxManageable(Request $request) {

        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );
        $data = Hospital::orderBy( $order_cols, $order_by )->orderByDesc( 'updated_at' );

        return Datatables::of( $data )->addColumn( 'action', function( $row ) {
                return $action = ' <a href="' . route( admin_route( 'hospitalsurvey.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-address-card"></i></a> ';
            } )->editColumn( 'is_active', function( $row ) {
                return $row->status;
            } )->editColumn( 'created_at', function( $row ) {
                return admin_datetime_format( $row->created_at, true );
            } )->rawColumns( [ 'action' ] )->make( true );
    }

    public function show( $id ) {
        $data = Hospital::where( 'id', $id )->first();
        $patient_infection             = PatientInfection::where( 'facility_id', $data->facility_id )->get();
        $patient_survey                = PatientSurvey::where( 'facility_id', $data->facility_id )->get();
        $patient_death_complication    = PatientComplicationAndDeath::where( 'facility_id', $data->facility_id )->get();
        $patient_unplanned_visit       = PatientUnplannedVisit::where( 'facility_id', $data->facility_id )->get();
        $patient_timely_effective_care = PatientTimelyAndEffectiveCare::where( 'facility_id', $data->facility_id )->get();

        return view( admin_module_view( 'show', $this->module ), compact( 'data', 'patient_infection', 'patient_survey', 'patient_death_complication', 'patient_unplanned_visit', 'patient_timely_effective_care' ) );
    }

    public function getHospitalChangeReqInfo() {
        return view( admin_module_view( 'manage_change_info_req', $this->module ) );
    }

    public function ajaxHospitalChangeReqInfo() {
        $data = UserHospitalInfo::latest( 'id' );
        return Datatables::of( $data )->addColumn( 'action', function( $row ) {
                return $action = ' <a href="' . route( admin_route( 'hospitalsurvey.form.change_info_req' ), [ $row->id ] ) . '" class="btn btn-success btn-sm"><i class="fas fa-user-check"></i></a> ';
            } )->addIndexColumn()->editColumn( 'user_id', function( $row ) {
                return $row->user->full_name ?? null;
            } )->editColumn( 'hospital_id', function( $row ) {
                return $row->hospital->facility_name;
            } )->editColumn( 'ref_url', function( $row ) {
                return ' <a href="' .  $row->ref_url . '" target="_blank">View URL</a> ';
            } )->editColumn( 'logo_image', function( $row ) {
                return $row->logo_image ? '<img src="' . $row->logo_image_url . '" width="80px" height="80px" />' : '-';
            } )->editColumn( 'is_approved', function( $row ) {
                return $row->approved_status;
            } )->rawColumns( [ 'action', 'logo_image', 'ref_url' ] )->make( true );
    }

    public function formHospitalChangeReqInfo( $id ) {
        $data = UserHospitalInfo::findOrFail( $id );

        return view( admin_module_view( 'request-form.form', $this->module ), compact( 'data' ) );
    }

    /**
     * Hospital - Save Request Infomration
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     */
    public function postHospitalChangeReqInfo( Request $request, $id ) {

        $validator = \Validator::make( $request->all(), [
            'name'                => 'required|max:100',
            'phone_number'        => 'required|regex:/[0-9]/|max:20',
            'logo_image'          => 'dimensions:min_width=300,min_height=300',
            'ref_url'             => 'required|max:100',
            'video_one_youtube'   => 'nullable|url',
            'video_two_youtube'   => 'nullable|url',
            'video_three_youtube' => 'nullable|url',
        ], [], [
            'ref_url' => 'Website URL'
        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        $trans       = UserHospitalInfo::findOrFail( $id );
        $prev_status = $trans->is_approved;
        $curr_status = (int) $request->is_approved;
        if ( $request->hasFile( 'logo_image' ) ) {

            $file      = $request->file( 'logo_image' );
            $file_name = ( $request->logo_image . 'logo_image' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->logo_image ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->logo_image, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $logo_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $logo_image );
            $trans->logo_image = $logo_image;
        }
        $extra = [
            'video_one_status' => $request->video_one_status ?? 0,
            'video_one_youtube' => $request->video_one_youtube ?? null,
            'video_two_status' => $request->video_two_status ?? 0,
            'video_two_youtube' => $request->video_two_youtube ?? null,
            'video_three_status' => $request->video_three_status ?? 0,
            'video_three_youtube' => $request->video_three_youtube ?? null,
        ];

        if ( $request->hasFile( 'right_image' ) ) {

            $file      = $request->file( 'right_image' );
            $file_name = ( $request->right_image . 'right_image' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->right_image ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->right_image, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $right_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $right_image );
            $trans->right_image = $right_image;
        }

        if ( $request->hasFile( 'video_one' ) ) {
            $file      = $request->file( 'video_one' );
            $file_name = ( $request->video_one . 'video_one' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_one ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_one, Hospital::$storage_disk );
            }
            $video_one = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_one );
            $trans->video_one      =  $video_one;

        }

        if ( $request->hasFile( 'video_two' ) ) {

            $file      = $request->file( 'video_two' );
            $file_name = ( $request->video_two . 'video_two' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_two ) {
                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_two, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $video_two = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_two );
            $trans->video_two      = $video_two;

        }

        if ( $request->hasFile( 'video_three' ) ) {

            $file      = $request->file( 'video_three' );
            $file_name = ( $request->video_three . 'video_three' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_three ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_three, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $video_three = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_three );
            $trans->video_three      = $video_three;

        }

        $trans->name         = $request->name ?: null;
        $trans->phone_number = $request->phone_number ?: null;
        $trans->ref_url      = $request->ref_url ?: null;
        $trans->extras      =  $extra ?: null;
        $trans->is_approved  = $curr_status;
        $trans->is_publish  = $curr_status;
        $trans->save();

        $data = $trans;
        if ( $prev_status == 0 && $curr_status ) {
            $subject         = "[" . $trans->name . "] - Changes Approved";
            $data['h6'] .= "Congratulations!";
            $data['h4'] .= 'Content Approved';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;"> Congratulations! Your website content has been approved by Admin. Now you can publish the approved content.</span>';
            $data['email']   .= $trans->user->email;
            $order           = Order::where( 'user_id', $trans->user->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video         = $order->hasOneOrderItem->product->extras??0;
            $data['video'] = $video;
        } else {

            $subject         = "[" . $trans->name . "] - Changes have been made by Admin";
            $setting         = Setting::where( 'key', 'sites' )->first();
            $data['h6'] .= null;
            $data['h4'] .= 'Changes have been Made By Admin';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;">Following content has been changed by the Admin. </span>';
            $data['email']   .= $trans->user->email;
            $order           = Order::where( 'user_id', $trans->user->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video         = $order->hasOneOrderItem->product->extras??0;
            $data['video'] = $video;
        }
//       dd( $data['video']);



        try {
            \Mail::to( $trans->user->email )->send( new \App\Modules\User\Mail\UserMail( 'dashboard-user-email', $subject, $data ) );

        } catch( \Exception $e ) {
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Request Information have been updated successfully.'
        ] );

        return redirect()->route( admin_route( 'hospitalsurvey.change_info_req' ) );
    }
}
