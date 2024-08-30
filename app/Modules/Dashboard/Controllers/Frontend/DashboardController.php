<?php namespace App\Modules\Dashboard\Controllers\Frontend;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Order;
use App\Models\StripeProductPrice;
use App\Models\UserHospitalInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends \App\Http\Controllers\Controller
{
    public $module = 'Dashboard';

    public function __construct()
    {
        if ( ! auth()->check() ) {
            return redirect('/');
        }
    }

    /**
     * Show the application Dashboard
     *
     */
    public function indexDashboard()
    {

        $user_hospital_details = $data = $order = null;

        if ( auth()->user() ) {
            $user_hospital_details = UserDetail::where( 'user_id', auth()->user()->id )->first();
            $data                  = UserHospitalInfo::where( 'user_id', auth()->user()->id )->first();
            $order                 = Order::where( 'user_id', auth()->user()->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
        }

        return view( frontend_module_view( 'dashboard', $this->module ), compact( 'data', 'user_hospital_details','order' ) );
    }
}
