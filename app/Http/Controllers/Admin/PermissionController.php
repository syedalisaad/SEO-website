<?php namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\PermissionRequest;

use DataTables;

class PermissionController extends \App\Http\Controllers\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        return view( admin_view( 'permissions.manage' ) );
    }

    public function ajaxManageable()
    {
        $data = Permission::all();

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $actions = '
                <a href="'.route(admin_route('permission.edit'), [$row->id]).'" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> 
                <a href="javascript:void(0)" data-href="'.route(admin_route('permission.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>
             ';

            return $actions;
        })
        ->addIndexColumn()
        ->editColumn('created_at', function($row) {
            return admin_datetime_format($row->created_at, true);
        })
        ->rawColumns(['action', 'source_image'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( admin_view('permissions.form') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        Permission::create(['name' => $request->name]);

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully added'
        ]);

        return redirect()->route( admin_route( 'permission.index' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $data = $permission;

        return view( admin_view('permissions.form'), compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->name = $request->name;
        $permission->save();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route(admin_route('permission.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $find_id )
    {
        $delete = Permission::findOrFail( $find_id );
        $delete->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);

        return redirect()->route(admin_route('permission.index'));
    }
}
