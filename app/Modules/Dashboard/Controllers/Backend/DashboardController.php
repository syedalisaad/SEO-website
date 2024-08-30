<?php namespace App\Modules\Dashboard\Controllers\Backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class DashboardController extends \App\Http\Controllers\AdminController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $user = getAuth();

        return view( admin_module_view('dashboard', 'Dashboard') );
    }

    /**
     * Show the application "Media Manager".
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mediaManager()
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$SETTING['MEDIA_MANAGER'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'media-manager', 'Dashboard' ) );
    }
}
