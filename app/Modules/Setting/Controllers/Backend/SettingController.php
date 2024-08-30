<?php namespace App\Modules\Setting\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\StripeProduct;
use App\Models\User;
use App\Support\Traits\{UploadableTrait,
    StorageableTrait
};
use Illuminate\Http\UploadedFile;

class SettingController extends \App\Http\Controllers\AdminController {
    protected $repo_hospital_survey;
    public $module = 'Setting';

    public function __construct( \App\Modules\HospitalSurvey\Respository\HospitalSurveyRespository $repo_hospital_survey ) {
        $this->repo_hospital_survey = $repo_hospital_survey;
    }

    use UploadableTrait, StorageableTrait;

    public function postHospitalSurveyJobs( Request $request ) {
        $request->session()->flash( 'account-tab', 'hospital-survey' );
        if ( $request->type_of != 'GENERAL_HOSPITAL' ) {
            $rules = \Validator::make( $request->all(), [
                'patient_category' => 'required',
            ] );
            if ( $rules->fails() ) {
                return redirect()->back()->withErrors( $rules )->withInput();
            }
        }


        $data = $this->repo_hospital_survey->forApiHospitalCreateOrUpdate( $request );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Job has been run successfully.'
        ] );

        return redirect()->route( admin_route( 'site.setting' ) );
    }

    public static $SCHEDULE = [
        'AfterMinute' => 'After Minute',
        'Afterhourly' => 'After an hourly',
        'dailyAt'     => 'Daily At',
        'weeklyOn'    => 'Weekly On',
        'monthlyOn'   => 'Monthly On'
    ];

    public function getSites() {
        $is_settings = ( in_array( \Perms::$SETTING['GENERAL'], getAuth()->role_permissions ) || in_array( \Perms::$SETTING['SOCIAL_NETWORK'], getAuth()->role_permissions ) || in_array( \Perms::$SETTING['CONTACT_SUPPORT'], getAuth()->role_permissions ) || in_array( \Perms::$SETTING['FRONTEND_SUPPORT'], getAuth()->role_permissions ) || in_array( \Perms::$SETTING['PAYMENT_GATEWAY'], getAuth()->role_permissions ) || in_array( \Perms::$SETTING['CHANGE_PASSWORD'], getAuth()->role_permissions ) );
        if ( true !== ( isAdmin() || $is_settings ) ) {
            abort( 403, "You don't have permission to view this page" );
        }
        $data     = [];
        $settings = Setting::all();
        if ( count( $settings ) ) {
            foreach ( $settings as $key => $value ) {
                $data[ $value->key ] = $value->value;
            }
        }
        $schedule = self::$SCHEDULE;

        #return view( 'Setting::admin.setting_template', ['data' => $data]);
        return view( admin_module_view( 'setting_template', $this->module ), compact( 'settings', 'schedule' ), [ 'data' => $data ] );
    }

    public function postSites( Request $request ) {


        // Site Configurations
        if ( $request->sites ) {
            $sites = $request->sites;
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Setting::$storage_disk );

            /**
             * Create upload logo or Update
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $sites['site_logo'] ) && $sites['site_logo'] instanceof UploadedFile ) {
                if ( isset( $sites['h_site_logo'] ) && $sites['h_site_logo'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $sites['h_site_logo'] ), Setting::$storage_disk );
                }
                $file               = $sites['site_logo'];
                $file_name          = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $sites['site_logo'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $sites['site_logo'] );
            } else {
                $sites['site_logo'] = $sites['h_site_logo'] ?? '';
            }
            if ( isset( $sites['site_logo_footer'] ) && $sites['site_logo_footer'] instanceof UploadedFile ) {
                if ( isset( $sites['h_site_logo_footer'] ) && $sites['h_site_logo_footer'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $sites['h_site_logo_footer'] ), Setting::$storage_disk );
                }
                $file               = $sites['site_logo_footer'];
                $file_name          = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $sites['site_logo_footer'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $sites['site_logo_footer'] );
            } else {
                $sites['site_logo_footer'] = $sites['h_site_logo_footer'] ?? '';
            }
            if ( isset( $sites['share_logo'] ) && $sites['share_logo'] instanceof UploadedFile ) {
                if ( isset( $sites['h_share_logo'] ) && $sites['h_share_logo'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $sites['h_share_logo'] ), Setting::$storage_disk );
                }
                $file               = $sites['share_logo'];
                $file_name          = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $sites['share_logo'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $sites['share_logo'] );
            } else {
                $sites['share_logo'] = $sites['h_share_logo'] ?? '';
            }

            /**
             * Create upload fav or Update
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $sites['site_favicon'] ) && $sites['site_favicon'] instanceof UploadedFile ) {
                if ( isset( $sites['h_site_favicon'] ) && $sites['h_site_favicon'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $sites['h_site_favicon'] ), Setting::$storage_disk );
                }
                $file                  = $sites['site_favicon'];
                $file_name             = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $sites['site_favicon'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $sites['site_favicon'] );
            } else {
                $sites['site_favicon'] = $sites['h_site_favicon'] ?? '';
            }
            $sites = \Arr::except( $sites, [ 'h_site_logo', 'h_site_logo_footer', 'h_site_favicon' ] );
            Setting::where( 'key', 'sites' )->update( array( 'value' => json_encode( $sites ) ) );
            // dd(json_encode($sites));
        }
        // Contact Support || SEO Meta Tags
        if ( $request->contact_support || $request->seo_metadata ) {
            $request->session()->flash( 'account-tab', 'contact-support' );
            Setting::where( 'key', 'contact_support' )->update( array( 'value' => json_encode( $request->contact_support ) ) );
            Setting::where( 'key', 'seo_metadata' )->update( array( 'value' => json_encode( $request->seo_metadata ) ) );
        }
        // Frontend Support
        if ( $request->frontend_support ) {
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Setting::$storage_disk );
            $frontend_support     = $request->frontend_support;
            $frontend_video_box_1 = $frontend_support['frontend_video_box_1'] ?? null;
            $frontend_video_box_2 = $frontend_support['frontend_video_box_2'] ?? null;
            /**
             * Create upload "Frontend Support - Video Box 1"
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $frontend_video_box_1['source'] ) && $frontend_video_box_1['source'] instanceof UploadedFile ) {
                if ( isset( $frontend_video_box_1['h_source'] ) && $frontend_video_box_1['h_source'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $frontend_video_box_1['h_source'] ), Setting::$storage_disk );
                }
                $file                           = $frontend_video_box_1['source'];
                $file_name                      = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $frontend_video_box_1['source'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $frontend_video_box_1['source'] );
            } else {
                $frontend_video_box_1['source'] = $frontend_video_box_1['h_source'] ?? '';
            }
            /**
             * Create upload "Frontend Support - Video Box 1"
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $frontend_video_box_1['video_upload'] ) && $frontend_video_box_1['video_upload'] instanceof UploadedFile ) {
                if ( isset( $frontend_video_box_1['h_video_upload'] ) && $frontend_video_box_1['h_video_upload'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $frontend_video_box_1['h_video_upload'] ), Setting::$storage_disk );
                }
                $file                           = $frontend_video_box_1['video_upload'];
                $file_name                      = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $frontend_video_box_1['video_upload'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $frontend_video_box_1['video_upload'] );
            } else {
                $frontend_video_box_1['video_upload'] = $frontend_video_box_1['h_video_upload'] ?? '';
            }

            /**
             * Create upload "Frontend Support - Video Box 1"
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $frontend_video_box_2['video_upload'] ) && $frontend_video_box_2['video_upload'] instanceof UploadedFile ) {
                if ( isset( $frontend_video_box_2['h_video_upload'] ) && $frontend_video_box_2['h_video_upload'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $frontend_video_box_2['h_video_upload'] ), Setting::$storage_disk );
                }
                $file                           = $frontend_video_box_2['video_upload'];
                $file_name                      = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $frontend_video_box_2['video_upload'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $frontend_video_box_2['video_upload'] );
            } else {
                $frontend_video_box_2['video_upload'] = $frontend_video_box_2['h_video_upload'] ?? '';
            }

            if ( isset($frontend_video_box_1['remove_video']) && $frontend_video_box_1['remove_video'] != 0 ) {

                $frontend_video_box_1['video_upload'] = '';
                $frontend_support['frontend_video_box_1'] = \Arr::except( $frontend_video_box_1, [ 'remove_video' ] );
            }
            if ( isset($frontend_video_box_2['remove_video']) && $frontend_video_box_2['remove_video'] != 0 ) {

                $frontend_video_box_2['video_upload'] = '';
                $frontend_support['frontend_video_box_2'] = \Arr::except( $frontend_video_box_2, [ 'remove_video' ] );
            }
            /**
             * Create upload "Frontend Support - Video Box 2"
             * @array \Illuminate\Http\Request  $request
             */
            if ( isset( $frontend_video_box_2['source'] ) && $frontend_video_box_2['source'] instanceof UploadedFile ) {
                if ( isset( $frontend_video_box_2['h_source'] ) && $frontend_video_box_2['h_source'] ) {
                    // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                    $this->fileDeleteFromDisk( basename( $frontend_video_box_2['h_source'] ), Setting::$storage_disk );
                }
                $file                           = $frontend_video_box_2['source'];
                $file_name                      = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
                $frontend_video_box_2['source'] = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
                // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
                $this->uploadOne( $file, Setting::$storage_disk, $frontend_video_box_2['source'] );
            } else {
                $frontend_video_box_2['source'] = $frontend_video_box_2['h_source'] ?? '';
            }
            $frontend_support['frontend_video_box_1'] = \Arr::except( $frontend_video_box_1, [ 'h_source' ] );
            $frontend_support['frontend_video_box_2'] = \Arr::except( $frontend_video_box_2, [ 'h_source' ] );
            $frontend_support['frontend_video_box_1'] = \Arr::except( $frontend_video_box_1, [ 'h_video_upload' ] );
            $frontend_support['frontend_video_box_2'] = \Arr::except( $frontend_video_box_2, [ 'h_video_upload' ] );
            $request->session()->flash( 'account-tab', 'frontend-support' );
            Setting::where( 'key', 'frontend_support' )->update( array( 'value' => json_encode( $frontend_support ) ) );
        }
        // Payment Gateway
        if ( $request->payment_gateway ) {
            $request->session()->flash( 'account-tab', 'payment-gateway' );
            Setting::where( 'key', 'payment_gateway' )->update( array( 'value' => json_encode( $request->payment_gateway ) ) );

            $stripe_pacakges = $request->stripe_pacakges;
            $stripe_pacakges_all = \App\Models\StripeProduct::isGatwayMode()->pluck('name', 'id');
            if(!empty($stripe_pacakges)) {
                foreach ( $stripe_pacakges_all as $id => $name ) {
                    if(in_array($id, array_keys($stripe_pacakges))) {
                        StripeProduct::where( 'id','=', $id )
                                     ->update( array( 'is_active' => $stripe_pacakges[$id]['is_active'] ) );
                    }
                    else {
                        StripeProduct::where( 'id','=', $id )->update( array( 'is_active' => 0 ) );
                    }
                }
            }
        }
        // Social Links URL
        if ( $request->social_links ) {
            $request->session()->flash( 'account-tab', 'social-network' );
            Setting::where( 'key', 'social_links' )->update( array( 'value' => json_encode( $request->social_links ) ) );
        }
        if ( $request->announcements ) {
            $request->session()->flash( 'account-tab', 'announcements' );
            if ( isset( $request->announcements['end_date_status'] ) && isset( $request->announcements['end_date'] ) ) {
                $rules         = \Validator::make( $request->announcements, [
                    'start_date' => 'date|date_format:Y-m-d|before:end_date|after:yesterday',
                    'end_date'   => 'date|date_format:Y-m-d|after:start_date'
                ] );
                $announcements = $request->announcements;
            } else {
                $rules         = \Validator::make( $request->announcements, [
                    'start_date' => 'date|date_format:Y-m-d|after:yesterday',
                ] );
                $announcements = $request->announcements;
                $announcements = \Arr::except( $announcements, [ 'end_date' ] );
            }

            if ( $rules->fails() ) {

                return redirect( route( admin_route( 'site.setting' ) ) )->withErrors( $rules )->withInput();
            }

            Setting::where( 'key', 'announcements' )->update( array( 'value' => json_encode( $announcements ) ) );
        }
        // Developer Self Rule Policy
        if ( $request->developers ) {
            $request->session()->flash( 'account-tab', 'developer-option' );
            Setting::where( 'key', 'developers' )->update( array( 'value' => json_encode( $request->developers ) ) );
        }
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully updated'
        ] );

        return redirect()->route( admin_route( 'site.setting' ) );
    }

    public function postChangePassword( Request $request ) {
        $rules = \Validator::make( $request->all(), [
            'old_password'    => 'required|max:20',
            'new_password'    => 'required|max:20|required_with:confirm_password|same:repeat_password',
            'repeat_password' => 'required|max:20',
        ] );
        $request->session()->flash( 'account-tab', 'change-password' );
        if ( $rules->fails() ) {
            return redirect( route( admin_route( 'site.setting' ) ) )->withErrors( $rules )->withInput();
        }
        $user = User::findOrFail( getAuth()->id );
        if ( ! \Hash::check( $request->old_password, $user->password ) ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'Password does not match.'
            ] );

            return redirect( route( admin_route( 'site.setting' ) ) );
        }
        $user->password = \Hash::make( $request->new_password );
        $user->save();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Password has been successfully changed'
        ] );

        return redirect( route( admin_route( 'site.setting' ) ) );
    }

    public function postAuthSetting( Request $request ) {
        $rules = \Validator::make( $request->all(), [
            'first_name' => 'required|max:20',
            'last_name'  => 'required|max:20'
        ] );
        $request->session()->flash( 'account-tab', 'auth-setting' );
        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }
        $user             = User::findOrFail( getAuth()->id );
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->save();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Auth Setting has been successfully saved'
        ] );

        return redirect()->route( admin_route( 'site.setting' ) );
    }
}
