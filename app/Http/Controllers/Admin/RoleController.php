<?php namespace App\Http\Controllers\Admin;

#use App\Models\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

#use App\Support\Services\RoleService;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\RoleRequest;

use DataTables;

class RoleController extends \App\Http\Controllers\AdminController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$ROLE['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_view( 'roles.manage' ) );
    }

    public function ajaxManageable()
    {
        $data = Role::all();

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';

            if( isAdmin() || getAuth()->can(\Perms::$ROLE['UPDATE']) ) {
                $action .= '<a href="'.route(admin_route('role.edit'), [$row->id]).'" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
            }

            if( isAdmin() || getAuth()->can(\Perms::$ROLE['DELETE']) ) {
                $action .= '<a href="javascript:void(0)" data-href="'.route(admin_route('role.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }

            return $action?:'-';
        })
        ->addIndexColumn()
        ->addColumn( 'permissions', function( $row ) {
            return $row->permissions->pluck('name')->implode('<br/>');
        })
        ->editColumn('created_at', function($row) {
            return admin_datetime_format($row->created_at, true);
        })
        ->rawColumns(['action', 'permissions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$ROLE['ADD'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_view('roles.form') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = array_filter( $request->permissions );
        $role->syncPermissions( $permissions );

        //Redirection when you choose button
        $route_action = route(admin_route($request->formsubmit));

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully added'
        ]);

        return redirect( $route_action );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$ROLE['UPDATE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $data = $role;

        return view( admin_view('roles.form'), compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();

        $permissions = array_filter($request->permissions);
        $role->syncPermissions($permissions);

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route(admin_route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $find_id )
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$ROLE['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $delete = Role::findOrFail( $find_id );
        $delete->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);

        return redirect()->route(admin_route('role.index'));
    }
}
