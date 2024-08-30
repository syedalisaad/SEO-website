<?php namespace App\Modules\Page\Controllers\Frontend;

use App\Models\PatientComplicationAndDeath;
use App\Models\PatientInfection;
use App\Models\PatientSurvey;
use App\Models\PatientTimelyAndEffectiveCare;
use App\Models\PatientUnplannedVisit;
use App\Models\Setting;
use App\Models\User;
use App\Modules\ApiJob\Controllers\ApiLogController;
use App\Modules\Contact\Mail\ContactFrontMail;
use App\Modules\Page\Request\ReCaptcha;
use Illuminate\Http\Request;
use \App\Models\Page;
use \App\Models\Hospital;
use \App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class PageController extends \App\Http\Controllers\Controller {
    public $module = 'Page';

    static $distance_in_miles = '25.000'; //'40.2336';
    static $distance_in_miles_default = '25.000'; //'40.2336';
    /**
     * Show the application About Us
     */
    public function getAbout() {
        $data         = Page::isActive()->whereSlug( Page::$PAGE_ABOUT )->firstOrFail();
        $page_title   = $data->name;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'about', $this->module ), compact( 'data', 'page_title', 'seo_metadata' ) );
    }


    public function getUnpaid( $id ) {
        $hospital = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        if ( $hospital->hospital_info && $hospital->hospital_info->is_approved == 1 && $hospital->hospital_info->is_publish == 1 ) {
            if ( $hospital->hospital_info ) {
                $subscribe_order = get_current_subscription( $hospital->hospital_info->user_id );
            } else {
                $subscribe_order = null;
            }
            if ( $subscribe_order ) {
                return redirect( route( front_route( 'page.premium' ), [ 'slug' => $id ] ) );
            }
        }
        $banner                 = 1;
        $healthcare_volume      = PatientTimelyAndEffectiveCare::where( 'measure_id', 'EDV' )->where( 'facility_id', $id )->first();
        $healthcare_vaccination = PatientTimelyAndEffectiveCare::where( 'measure_id', 'IMM_3' )->where( 'facility_id', $id )->first();
        $data                   = Page::isActive()->whereSlug( Page::$PAGE_ABOUT )->firstOrFail();
        $page_title             = $hospital->facility_name . ' | Hospital';
        $seo_metadata           = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'unpaid', $this->module ), compact( 'banner', 'data', 'hospital', 'page_title', 'seo_metadata', 'healthcare_volume', 'healthcare_vaccination' ) );
    }

    /**
     * Show the application "Hospitals Near Me"
     */
    public function getHospitalList( Request $request ) {
        $data         = Page::isActive()->whereSlug( Page::$PAGE_HOSPITAL_NEAR_ME )->firstOrFail();
        $page_title   = $data->name;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'hospitals-near-me', $this->module ), compact( 'data', 'page_title', 'seo_metadata' ) );
    }

    /**
     * Show the application Patient Infection.
     */
    public function getInfection( $id ) {
        $hospital   = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        $page_title = $hospital->facility_name . ' | Patient Infection';
        $banner     = 1;
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
        }


        return view( frontend_module_view( 'hospitalScore/infection', $this->module ), compact( 'banner', 'page_title', 'hospital', 'subscribe_order' ) );
    }

    /**
     * Show the application Infection national.
     */
    public function getInfectionNational() {
        $page_title = 'National Infection';
        $banner     = 1;

        return view( frontend_module_view( 'hospitalScore/national_infection', $this->module ), compact( 'banner', 'page_title' ) );
    }

    /**
     * Show the application Patient Survey.
     */
    public function getSurvey( $id ) {
        $hospital   = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        $page_title = $hospital->facility_name . ' | Patient Experience';
        $banner     = 1;
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
        }



        return view( frontend_module_view( 'hospitalScore/patient_experience', $this->module ), compact( 'banner', 'page_title', 'hospital','subscribe_order' ) );
    }


    /**
     * Show the application Patient Unplanned Visit.
     */
    public function getReadmission( $id ) {
        $hospital   = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        $page_title = $hospital->facility_name . ' | Patient Readmission';
        $banner     = 1;
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
        }


        return view( frontend_module_view( 'hospitalScore/readmission', $this->module ), compact( 'banner', 'page_title', 'hospital','subscribe_order' ) );
    }
    /**
     * Show the application patient timly and effective care.
     */
    public function getSpeedOfCare( $id ) {
        $hospital   = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        $page_title = $hospital->facility_name . ' | Patient Speed Of Care';
        $banner     = 1;
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
        }


        //national data condition
        return view( frontend_module_view( 'hospitalScore/speed_of_care', $this->module ), compact( 'banner', 'page_title', 'hospital','subscribe_order' ) );
    }

    /**
     * Show the application Death and Complications.
     */
    public function getDeathAndComplications( $id ) {
        $hospital   = Hospital::isActive()->where( 'slug', $id )->firstOrFail();
        $page_title = $hospital->facility_name . ' | Patient Death And Complications ';
        $banner     = 1;
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
        }



        return view( frontend_module_view( 'hospitalScore/death_and_complication', $this->module ), compact( 'banner', 'page_title', 'hospital','subscribe_order' ) );
    }

    /**
     * Show the application national  Death and Complications.
     */
    public function getDeathAndComplicationsNational() {
        $page_title = 'National Death And Complications';
        $banner     = 1;


        return view( frontend_module_view( 'hospitalScore/national_death_and_complication', $this->module ), compact( 'banner', 'page_title' ) );
    }


    /**
     * Show the application National Avarages.
     */
    public function getNationalAvarages() {
        $page_title = 'National Avarages';
        $banner     = 1;

        return view( frontend_module_view( 'hospitalScore/national-avarages', $this->module ), compact( 'banner', 'page_title' ) );
    }

    /**
     * Show the application Patient Survey.
     */
    public function getSurveyNational() {
        $page_title = 'National Experience';
        $banner     = 1;

        return view( frontend_module_view( 'hospitalScore/national_patient_experience', $this->module ), compact( 'banner', 'page_title' ) );
    }

    /**
     * Show the application National Unplanned Visit.
     */
    public function getReadmissionNational() {
        $page_title = 'National Readmission';
        $banner     = 1;

        return view( frontend_module_view( 'hospitalScore/national_readmission', $this->module ), compact( 'banner', 'page_title' ) );
    }



    /**
     * Show the application timly and effective car national.
     */
    public function getSpeedOfCareNational() {
        $page_title = 'National Speed Of Care';
        $banner     = 1;

        return view( frontend_module_view( 'hospitalScore/national_speed_of_care', $this->module ), compact( 'banner', 'page_title' ) );
    }

    /**
     * Show the application FAQ's
     */
    public function getFAQs() {
        $data         = Page::isActive()->whereSlug( Page::$PAGE_FAQ )->firstOrFail();
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'faqs', $this->module ), compact( 'data', 'seo_metadata' ) );
    }

    /**
     * Show the application email
     */
    public function getEmail() {
        $data         = [];
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'email', $this->module ), compact( 'data', 'seo_metadata' ) );
    }

    /**
     * Show the application Premium
     */
    public function getPremium( $id ) {

        $banner                 = 1;
        $healthcare_volume      = PatientTimelyAndEffectiveCare::where( 'measure_id', 'EDV' )->where( 'facility_id', $id )->first();
        $healthcare_vaccination = PatientTimelyAndEffectiveCare::where( 'measure_id', 'IMM_3' )->where( 'facility_id', $id )->first();
        $hospital               = Hospital::isActive()->where( 'slug', $id )->firstOrFail();

        if ( $hospital->hospital_info && $hospital->hospital_info->is_approved != 1 && $hospital->hospital_info->is_publish != 1 ) {
            return redirect( route( front_route( 'page.unpaid' ), [ 'slug' => $id ] ) );
        }
        if($hospital->hospital_info){
        $subscribe_order = get_current_subscription($hospital->hospital_info->user_id);
        }else{
            $subscribe_order = null;
            return redirect( route( front_route( 'page.unpaid' ), [ 'slug' => $id ] ) );

        }


        return view( frontend_module_view( 'premium', $this->module ), compact( 'hospital', 'banner', 'healthcare_vaccination', 'healthcare_volume','subscribe_order' ) );
    }

    /**
     * Show the application FAQs.
     */
    public function getPageManagement( $page ) {
        $data         = Page::isActive()->whereSlug( $page )->firstOrFail();
        $page_title   = $data->name;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'page-management', $this->module ), compact( 'data', 'page_title', 'seo_metadata' ) );
    }

    /**
     * Show the application FAQs.
     */
    public function getTerms() {
        $data         = Page::isActive()->whereSlug( Page::$PAGE_TERMS_OF_SERVICE )->firstOrFail();
        $page_title   = $data->name;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'terms', $this->module ), compact( 'data', 'page_title', 'seo_metadata' ) );
    }

    /**
     * Show the application Contact Us.
     */
    public function getContact() {
        $data         = [];
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'contact', $this->module ), compact( 'data', 'seo_metadata' ) );
    }

    /**
     * Page: Contact Us
     * Contact Us Anonymous Serviceability.
     */
    public function postContact( Request $request ) {
//        dd($request->all());
        $validator = \Validator::make( $request->all(), [
            'first_name' => 'required|max:15',
            'last_name'  => 'required|max:15',
            'email'      => 'required|email|max:40',
            'phone'      => 'required|regex:/[0-9]/|max:20',
            'message'    => 'required|max:250',
            'g-recaptcha-response'=>['required',new ReCaptcha]
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
//        dd($request->all());
        $full_name           = $request->first_name . ' ' . $request->last_name;
        $contact             = new \App\Models\Contact;
        $contact->name       = $full_name;
        $contact->email      = $request->email;
        $contact->phone      = $request->phone;
        $contact->message    = $request->message;
        $contact->ip_address = \Request::getClientIp();
        $contact->save();
        $subject = 'Thank you for contacting us';
        \Mail::to( $contact->email )->send( new \App\Modules\Page\Mail\PageMail( 'contact', $subject, $contact ) );

        //For "Admin" Email
        $admin_emails = User::getAdminEmailsList();

        if( count($admin_emails) )
        {
            $settings = get_site_settings();
            $sites    = $settings['sites'];
            $subject  = $sites['site_name'] . ' - Contact Query';

            foreach ( $admin_emails as $email ) {

                try {
                    \Mail::to( $email )->send( new ContactFrontMail( 'admin', $subject, $contact ) );
                } catch( \Exception $e ) {
                    Setting::failedSmtpMailSend( $e->getMessage() );
                }
            }
        }
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your query has been successfully submitted.'
        ] );

        return redirect()->route( front_route( 'page.contact' ) );
    }

    /**
     * Page: Newsletter
     * Newsletter Anonymous Serviceability.
     */
    public function postNewsletter( Request $request ) {
        $validator = \Validator::make( $request->all(), [
            'email' => 'required|email|unique:App\Models\Newsletter,email|max:40'
        ], [
            'unique' => 'This email is already subscribed'
        ] );
        if ( $validator->fails() ) {

            $errors = $validator->getMessageBag()->toArray();
            $errors = array_map( function( $v ) {
                return $v[0];
            }, $errors );

            return response()->json( [
                'status'     => false,
                'collection' => [
                    'errors' => $errors
                ]
            ] );
        }
        $subscirber             = new \App\Models\Newsletter;
        $subscirber->email      = $request->email;
        $subscirber->ip_address = \Request::getClientIp();
        $subscirber->save();
        $setings = get_site_settings();
        $subject = 'Congratulations, now you are a member of ' . ( $setings['sites']['site_name'] ?? 'Site Name' ) . '!';
        \Mail::to( $subscirber->email )->send( new \App\Modules\Page\Mail\PageMail( 'newsletter', $subject, $subscirber ) );

        return response()->json( [
            'status'     => true,
            'collection' => [
                'message'  => 'Your query has been successfully submitted.',
                'message1' => 'Your query has been successfully submitted.',
            ]
        ] );
    }

    public function postFacilityNameAjaxx( Request $request ) {
        $hospital = Hospital::where( 'facility_name', 'like', '%' . $request->term . '%' )->get();

        return response()->json( [ 'items' => $hospital, 'count' => $hospital->count() ] );
    }

    private function paginate( $items, $perPage = 10, $page = null ) {
        $page        = $page ?: ( Paginator::resolveCurrentPage() ?: 1 );
        $total       = count( $items );
        $currentpage = $page;
        $offset      = ( $currentpage * $perPage ) - $perPage;
        $itemstoshow = array_slice( $items, $offset, $perPage );

        return new LengthAwarePaginator( $itemstoshow, $total, $perPage );
    }

    private function getHospitalSearchQuery( Request $request )
    {
        $lat     = $request->lat;
        $lng     = $request->lng;
        $zipcode = $request->zipcode ? preg_replace('/\D/', '', $request->zipcode) : '';

        $args = ['hospitals.*', 'patient_survey.patient_survey_star_rating'];
        $QUERY =   Hospital::isActive()
                        ->whereNotNull( 'lng' )
                        ->leftJoin( 'patient_survey', 'hospitals.facility_id', '=', 'patient_survey.facility_id' )
                        ->select($args)
                        ->groupBy( 'hospitals.id' )
                        ;
        $QUERY->addSelect( \DB::raw( '
                            3959 * ACOS (
                              COS ( RADIANS(' . ( $lat ) . ') )
                              * COS( RADIANS( lat ) )
                              * COS( RADIANS( lng ) - RADIANS(' . ( $lng ) . ') )
                              + SIN ( RADIANS(' . ( $lat ) . ') )
                              * SIN( RADIANS( lat ) )
                            )
                        AS distance_miles' ) );
        if ( $request->hospital ) {
            $QUERY = $QUERY->where( 'hospitals.facility_name', 'like', '%' . $request->hospital . '%' );
        }
        if ( $zipcode && $request->zipcode_hidden ) {
            $QUERY = $QUERY->where( function( $query ) use ($request, $zipcode) {
                $query
                    ->orWhere( 'hospitals.zip_code', 'like', $zipcode . '%' );
                $query
                    ->orWhere( 'hospitals.zip_code', 'like', $request->zipcode_hidden . '%' );
            });
        }
        if ( $zipcode && !$request->zipcode_hidden  && $request->showInMiles === false ) {
            $QUERY = $QUERY->where( function( $query ) use ($request, $zipcode) {
                $query
                    ->orWhere( 'hospitals.zip_code', 'like', $zipcode . '%' )
                    ->orWhere( 'hospitals.city', 'like', $zipcode . '%' );
            });
        }


        if($lat > 0 && $request->showInMiles) {
            $QUERY = $QUERY->having( 'distance_miles', '<=',  self::$distance_in_miles );
        }
        $QUERY = $QUERY->orderByRaw('distance_miles ASC');

        return $QUERY;
    }
    public function getHospitals( Request $request ) {
        $message = '-1';
        $request->showInMiles = false;

        $page     = $request->page ?? 1;

        if ( $request->ajax() || true ) {
            $zipcode= strlen($request->zipcode);

            if($zipcode>3){
                $x = 0;
                $zip = $request->zipcode;
                do {
                    $result = substr($zip, 0, ($zipcode-$x));

                    $check_hospital = Hospital::where('zip_code','like',$zip."%")->first();
                    if(!$check_hospital){
                        $request->zipcode=$result;
                        $x++;
                    }else{
                        $request->zipcode=$result;
                        $x=6;
                    }

                } while ($x <= ($zipcode-3));
            }
            $hospital  = $this->getHospitalSearchQuery($request)->get();

            if($hospital->count() < 1) {
                $request->showInMiles = true;

                $hospital  = $this->getHospitalSearchQuery($request)->get();
                $message = 'No record found for this search, however you can see hospital near your location';
            }


            $hospital_toArray = $hospital->toArray();
            $list_view = $this->paginate( $hospital_toArray, 20, $page );
            $map_view  = $this->paginate( $hospital_toArray, 1, $page );

            return response()->json( [
                'success'      => true,
                'list_view'    => $list_view,
                'map_view'     => $map_view,
                'list_html'    => $this->generateMapHtml( $list_view->items() ),
                'map_html'     => $this->generateMapHtml( $map_view->items() ),
                'current_view' => $request->current_view,
                'no_record_message' => $message,
            ] );
        } else {
            return response()->json( [ 'invalid' => true ] );
        }
    }

    private function generateMapHtml($data) {
        $list_html = [];
        if (count($data) > 0) {
            $i = 1;
            foreach ( $data as $key => $item ) {
                if(isset($item['no_data']) && $item['no_data']) {
                    $html = '';
                    $html .= '<!-----' . $key . '----->';
                    $html .= '<div class="near-by-location">';
                    $html .=  '<span>'.$item['title'] .'</span>';
                    $html .= '</div>';
                }
                else if(isset($item['more_result']) && $item['more_result']) {
                    $html = '';
                    $html .= '<!-----' . $key . '----->';
                    $html .= '<div class="near-by-location">';
                    $html .=  '<span>'.$item['title'] .'</span>';
                    $html .= '</div>';
                }
                else {
                    $html = '';
                    $html .= '<!-----' . $item['id'] . '----->';
                    $html .= '<div class="detial" >';
                    $html .= '<a href="' . route( front_route( 'page.unpaid' ), $item['slug'] ) . '"><h3  class="hospital_name">' . $item['facility_name'] . '</h3></a>';
                    $html .= '<h5>' . $item['hospital_type'] . '</h5>';
                    $html .= '<p class="address">' . $item['formatted_address'] . '</p>';
                    $html .= '</div>';
                    $html .= view( frontend_module_view( 'stars', 'Page' ), [ 'hospital' => $item ] );

                }
                $i ++;
                $list_html[ $item['id'] ] = $html;
            }
        } else {
            $html         = '';
            $html         .= '<div class="detial" >';
            $html         .= '<h5>No Data Available</h5>';
            $html         .= '</div>';
            $list_html[0] = $html;
        }

        return $list_html;
    }


    public function zipcode_to_lat_lng( $location ) {
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
        } catch( \Exception $e ) {
            return false;
        }
    }

    public function getPrivacyPolicy() {
        //$data         = Page::isActive()->whereSlug( Page::$PAGE_HOSPITAL_NEAR_ME )->firstOrFail();
        $page_title   = 'Privacy Policy';
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'privacy-policy', $this->module ), compact( 'page_title', 'seo_metadata' ) );
    }
}
