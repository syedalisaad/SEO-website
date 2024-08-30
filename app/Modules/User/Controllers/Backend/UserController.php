<?php namespace App\Modules\User\Controllers\Backend;

use App\Models\User;
use App\Models\Setting;
use App\Models\UserDetail;
use App\Modules\Order\Respository\OrderRespository;
use DataTables;
use Illuminate\Http\Request;
use App\Modules\User\Request\UserRequest;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Support\Traits\StorageableTrait;


class UserController extends \App\Http\Controllers\AdminController
{
    protected $repo_service;

    use StorageableTrait;

    public $module = 'User';

    public function __construct( \App\Modules\User\Respository\UserRespository $user_respository ) {
        $this->repo_service = $user_respository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $is_trash = (bool) $request->has( 'trash' );

        return view( admin_module_view( 'manage', $this->module ), compact( 'is_trash' ) );
    }

    /*
     * User Lists
     * **/
    public function ajaxManageable( Request $request )
    {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );

        $data = User::where( 'user_type', '<>', User::$USER_ADMIN )->isVerifyEmail()->orderBy( $order_cols, $order_by )->orderByDesc( 'updated_at' );

        return Datatables::of( $data )
        ->filterColumn( 'full_name', function( $query, $keyword ) {
            $query->where( 'first_name', 'like', "%{$keyword}%" )->orWhere( 'last_name', 'like', "%{$keyword}%" );
        })
        ->filterColumn( 'is_active', function( $query, $keyword ) {
            $query->where( 'is_active', (int) ( strpos( 'active', strtolower( $keyword ) ) !== false ) );
        })
        ->addIndexColumn()->addColumn( 'action', function( $row ) {

            $action = '';
            if ( isAdmin() || getAuth()->can( \Perms::$USER['UPDATE'] ) ) {
                $action .= '<a href="' . route( admin_route( 'user.edit' ), [ $row->id ] ) . '" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
            }

            if ( isAdmin() || getAuth()->can( \Perms::$USER['DELETE'] ) ) {
                $action .= '<a href="javascript:void(0)" data-href="' . route( admin_route( 'user.delete' ), [ $row->id ] ) . '" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }

            if ( isAdmin() || getAuth()->can( \Perms::$USER['VIEW'] ) ) {
                $action .= ' <a href="' . route( admin_route( 'user.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-address-card"></i></a> ';
            }

            return $action ?: '-';
        })
        ->addColumn( 'hospital', function( $row ) {
            return $row->detail && $row->detail->hospital ? $row->detail->hospital->facility_name : '-';
        })
        ->addColumn( 'full_name', function( User $user ) {
            return $user->full_name;
        })
        ->addColumn( 'source_image', function( $row ) {
            return '<img src="' . $row->image_url . '" width="50" height="50" />';
        })
        ->addColumn( 'subscription_info', function( $row ) {

            if( $row->user_order ) {
                return $row->subscription_info_html;
            }

            return '-';
        })
        ->editColumn( 'is_active', function( $row ) {
            return $row->status;
        })
        ->editColumn( 'created_at', function( $row ) {
            return admin_datetime_format( $row->created_at, true );
        })
        ->rawColumns([
            'action', 'hospital', 'full_name', 'source_image', 'subscription_info'
        ])
        ->make( true );
    }

    /*
    * Users: Un Approved Lists
    * **/
    public function getUserUnverifiedIndex( Request $request ) {
        return view( admin_module_view( 'manage-unverified', $this->module ) );
    }

    public function ajaxUserUnverifiedManageable( Request $request )
    {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );

        $data       = User::where( 'user_type', '<>', User::$USER_ADMIN )->isAwaiting()->orderBy( $order_cols, $order_by )->orderByDesc( 'updated_at' );

        return Datatables::of( $data )
        ->filterColumn( 'full_name', function( $query, $keyword ) {
            $query->where( 'first_name', 'like', "%{$keyword}%" )->orWhere( 'last_name', 'like', "%{$keyword}%" );
        })
        ->filterColumn( 'is_active', function( $query, $keyword ) {
            $query->where( 'is_active', (int) ( strpos( 'active', strtolower( $keyword ) ) !== false ) );
        })
        ->addIndexColumn()
        ->addColumn( 'action', function( $row ) {

            $action = ' <a href="javascript:void(0)" data-toggle="tooltip" title="Resend Email" data-title="Are you sure you want to resend email?" data-href="' . route( admin_route( 'user.resend.email' ), [ $row->id ] ) . '" class="btn btn-info btn-sm const-confirm-records"><i class="fas fa-envelope"></i></a>';

            /*if ( isAdmin() || getAuth()->can( \Perms::$USER['DELETE'] ) ) {
                $action .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" data-href="' . route( admin_route( 'user.delete' ), [ $row->id ] ) . '" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }*/

            return $action ?: '-';
        })
        ->addColumn( 'full_name', function( User $user ) {
            return $user->full_name;
        })
        ->addColumn( 'source_image', function( $row ) {
            return '<img src="' . $row->image_url . '" width="50" height="50" />';
        })
        ->editColumn( 'is_active', function( $row ) {
            return $row->status;
        })
        ->editColumn( 'verifytoken', function( $row ) {
            $action = sprintf('<a href="%s" target="_blank">Verify Link</a> ', route( front_route('user.email.verified'), $row->verifytoken ));
            return $action ?: '-';
        })
        ->editColumn( 'created_at', function( $row ) {
            return admin_datetime_format( $row->created_at, true );
        })
        ->rawColumns( [
            'action', 'full_name', 'source_image', 'verifytoken'
        ])
        ->make( true );
    }

    /**
     * Resend Awaiting User send email.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resendUserEmail( Request $request, $user_id )
    {
        $user = User::findOrFail( $user_id );
        $subject = 'Email Verification';

        try {
            \Mail::to( $user->email )->send( new \App\Modules\User\Mail\FrontendUserMail( 'verify-register', $subject, $user ) );
            // \Mail::to( $user->email )->send( new \App\Modules\User\Mail\UserMail( 'verify-resent-register', $subject, $user ) );
        }
        catch( \Exception $e ) {
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => "We\'ve sent you an email!"
        ]);

        return redirect()->route( admin_route( 'user.unverified.index' ) );
    }

    /*
    * Users Hospitals: Un Approved Lists
     *
    * **/
    public function getUserUnverifiedHospitalIndex( Request $request ) {
        return view( admin_module_view( 'manage-unverified-hospitals', $this->module ) );
    }

    public function ajaxUserUnverifiedHospitalManageable( Request $request ) {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'users.created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );
        $data = User::select( 'users.*' )->orderBy( $order_cols, $order_by )->orderByDesc( 'users.updated_at' )->join( 'user_details AS ud', 'ud.user_id', '=', 'users.id' )->whereNotNull( 'users.email_verified_at' )->where( 'ud.is_hospital_approved', 0 );

        return Datatables::of( $data )->filterColumn( 'full_name', function( $query, $keyword ) {
                $query->where( 'users.first_name', 'like', "%{$keyword}%" )->orWhere( 'users.last_name', 'like', "%{$keyword}%" );
            } )->filterColumn( 'hospital_id', function( $query, $keyword ) {
                $query->where( 'hospitals.facility_name', 'like', "%{$keyword}%" );
            } )->addIndexColumn()->addColumn( 'action', function( $row ) {
                $action = ' <a href="javascript:void(0)" data-toggle="tooltip" title="Approve Hospital" data-title="Are you sure you want to approve hospital ?" data-href="' . route( admin_route( 'user.hospital.managestatus' ), [ $row->id, 1 ] ) . '" class="btn btn-success btn-sm const-confirm-records"><i class="fas fa-check"></i></a>';
                $action .= ' <a href="javascript:void(0)" data-toggle="tooltip" title="Reject Hospital" data-title="Are you sure you want to reject hospital ?" data-href="' . route( admin_route( 'user.hospital.managestatus' ), [ $row->id, - 1 ] ) . '" class="btn btn-danger btn-sm const-confirm-records"><i class="fas fa-times"></i></a>';

                return $action;
            } )->addColumn( 'full_name', function( User $user ) {
                return $user->full_name;
            } )->editColumn( 'hospital_id', function( $row ) {
                return $row->detail->hospital->facility_name;
            } )->editColumn( 'is_hospital_approved', function( $row ) {
                return $row->detail->hospital_status;
            } )->editColumn( 'created_at', function( $row ) {
                return admin_datetime_format( $row->created_at, true );
            } )->rawColumns( [ 'action', 'full_name' ] )->make( true );
    }

    /**
     * User Hospital :: Manageable Status
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function manageableHospitalStatus( Request $request, $user_id, $status )
    {
        $user             = User::findOrFail( $user_id );
        $exists_hospitals = UserDetail::where( 'is_hospital_approved', 1 )->pluck( 'hospital_id' )->toArray();

        if ( $status == 1 && in_array( $user->detail->hospital_id, $exists_hospitals ) ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'The hospital has already been taken'
            ] );

            return redirect()->route( admin_route( 'user.hospital.unverified.index' ) );
        }
        UserDetail::where( 'user_id', $user_id )->update( [ 'is_hospital_approved' => $status ] );

        $subject = 'Conguratulations - Your hospital has been approved';

        try {
            \Mail::to( $user->email )->send( new \App\Modules\User\Mail\UserMail( 'approved-hospitals', $subject, $user ) );
        } catch( \Exception $e ) {
            Setting::failedSmtpMailSend( $e->getMessage() );
        }

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => "We\'ve sent you an email!"
        ] );

        return redirect()->route( admin_route( 'user.hospital.unverified.index' ) );
    }

    /*
     * User Lists "Trashed"
     *
     * **/
    public function ajaxTrashManageable( Request $request ) {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );
        $data = User::onlyTrashed()->where( 'user_type', '<>', User::$USER_ADMIN )->isVerifyEmail()->orderBy( $order_cols, $order_by )->orderByDesc( 'updated_at' );

        return Datatables::of( $data )->filterColumn( 'full_name', function( $query, $keyword ) {
                $query->where( 'first_name', 'like', "%{$keyword}%" )->orWhere( 'last_name', 'like', "%{$keyword}%" );
            } )->filterColumn( 'is_active', function( $query, $keyword ) {
                $query->where( 'is_active', (int) ( strpos( 'active', strtolower( $keyword ) ) !== false ) );
            } )->addIndexColumn()->addColumn( 'action', function( $row ) {
                $action = '';
                $action .= '<a href="' . route( admin_route( 'user.undo' ), [ $row->id ] ) . '" class="btn btn-success btn-sm"><i class="fas fa-undo-alt"></i></a>';
                $action .= ' <a href="javascript:void(0)" data-href="' . route( admin_route( 'user.trash' ), [ $row->id ] ) . '" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';

                return $action ?: '-';
            } )->addColumn( 'full_name', function( User $user ) {
                return $user->full_name;
            } )->addColumn( 'source_image', function( $row ) {
                return '<img src="' . $row->image_url . '" width="50" height="50" />';
            } )->editColumn( 'is_active', function( $row ) {
                return $row->status;
            } )->editColumn( 'created_at', function( $row ) {
                return admin_datetime_format( $row->created_at, true );
            } )->rawColumns( [ 'action', 'full_name', 'source_image' ] )->make( true );
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( admin_module_view( 'form', $this->module ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( UserRequest $request )
    {
        $user = $this->repo_service->userCreateOrUpdate( $request, new User );

        $roles = [];
        if ( $request->roles && count( $request->roles ) ) {
            $roles = array_filter( $request->roles );
        }
        $user->syncRoles( $roles );

        $permissions = [];
        if ( $request->permissions && count( $request->permissions ) ) {
            $permissions = array_filter( $request->permissions );
        }
        $user->syncPermissions( $permissions );

        //Redirection when you choose button
        $route_action = route( admin_route( $request->formsubmit ) );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'User has been created successfully.'
        ]);

        return redirect( $route_action );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $find_id )
    {
        $data = User::findOrFail( $find_id );
        return view( admin_module_view( 'form', $this->module ), compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( UserRequest $request, $find_id )
    {
        $user = User::findOrFail( $find_id );
        $user = $this->repo_service->userCreateOrUpdate( $request, $user );
        $roles = [];

        if ( $request->roles && count( $request->roles ) ) {
            $roles = array_filter( $request->roles );
        }
        $user->syncRoles( $roles );

        $permissions = [];
        if ( $request->permissions && count( $request->permissions ) ) {
            $permissions = array_filter( $request->permissions );
        }
        $user->syncPermissions( $permissions );

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'User Details have been updated successfully.'
        ] );

        return redirect()->route( admin_route( 'user.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id )
    {
        //TODO::User Subscription Cancel
        //https://stripe.com/docs/api/subscriptions/cancel

        $obj = User::findOrFail( $id );

        if( $obj->user_order && $obj->user_order->transaction_detail )
        {
            getStripeCancelSubscriptionById( $obj->user_order->transaction_detail['id'] );

            \App\Models\Order::where('user_id', $obj->id)->update(['for_order_status' => OrderRespository::$FOR_ORDER_STATUS_CANCELLED]);
        }

        $obj->delete();

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully deleted'
        ]);

        return redirect( route( admin_route( 'user.index' ) ) );
    }

    public function forceTrash( Request $request, $id )
    {
        $trash = User::withTrashed()->findOrFail( $id );

        //For "User Profile"
        $this->fileDeleteFromDisk( $trash->source_image, User::$storage_disk );
        $trash->forceDelete();

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully undo'
        ]);

        return redirect( route( admin_route( 'user.index' ) ) );
    }

    public function undo( Request $request, $id )
    {
        $trash = User::withTrashed()->findOrFail( $id );
        $is_exist = User::where( 'email', 'like', $trash->email )->first();

        if ( $is_exist ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'This account "' . $is_exist->email . '" has been aleady exists.'
            ] );

            return redirect( route( admin_route( 'user.index' ), [ 'trash' => 1 ] ) );
        }

        $trash->restore();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully undo'
        ]);
        return redirect( route( admin_route( 'user.index' ) ) );
    }

    public function show( Request $request, $user_id )
    {
        $data = User::findOrFail( $user_id );

        return view( admin_module_view( 'show', $this->module ), compact( 'data' ) );
    }
}
