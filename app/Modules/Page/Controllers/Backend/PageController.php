<?php namespace App\Modules\Page\Controllers\Backend;

use App\Models\Page;

use Illuminate\Http\Request;
use App\Modules\Page\Request\PageRequest;

use DataTables;

class PageController extends \App\Http\Controllers\AdminController
{
    protected $repo_service;

    public $module = 'Page';

    public function __construct( \App\Modules\Page\Respository\PageRespository $page_respository ) {
        $this->repo_service = $page_respository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( TRUE !== (isAdmin() || (bool) getAuth()->can(\Perms::$PAGE['LIST'])) ) {
            abort(403, "You don't have permission to view this page");
        }

        return view( admin_module_view( 'manage', $this->module ) );
    }

    public function ajaxManageable()
    {
        $data = Page::latest();

        return Datatables::of($data)
        ->addColumn('action', function($row){
            $action = '';
            if ( isAdmin() || getAuth()->can( \Perms::$PAGE['UPDATE'] ) ) {
                $action .= '<a href="' . route( admin_route( 'page.edit' ), [ $row->id ] ) . '" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
            }

            if( isAdmin() || getAuth()->can(\Perms::$PAGE['DELETE']) )
            {
                if ( !$row->is_lock ) {
                    $action .= '<a href="javascript:void(0)" data-href="' . route( admin_route( 'page.delete' ), [ $row->id ] ) . '" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
                }
            }

            return $action?:'-';
        })
        ->addIndexColumn()
        ->filterColumn('is_active', function($query, $keyword) {
            $query->where( 'is_active', (int) (strpos('active', strtolower($keyword)) !== false));
        })
        ->editColumn('is_active', function($row) {
            return $row->status;
        })
        ->editColumn('created_at', function($row) {
            return admin_datetime_format($row->created_at, true);
        })
        ->rawColumns(['action', 'source_header'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( TRUE !== (isAdmin() || (bool) getAuth()->can(\Perms::$PAGE['ADD'])) ) {
            abort(403, "You don't have permission to view this page");
        }

        return view( admin_module_view( 'form', $this->module ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $this->repo_service->createOrUpdate( $request, new Page );

        //Redirection when you choose button
        $route_action = route(admin_route($request->formsubmit));

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully added'
        ]);
        return redirect( $route_action );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($find_id)
    {
        if( TRUE !== (isAdmin() || (bool) getAuth()->can(\Perms::$PAGE['UPDATE'])) ) {
            abort(403, "You don't have permission to view this page");
        }

        $data = Page::findOrFail($find_id);

        return view( admin_module_view( 'form', $this->module ), compact('data') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $find_id)
    {
        $model = Page::findOrFail($find_id);

        $this->repo_service->createOrUpdate( $request, $model );

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route( admin_route('page.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if( TRUE !== (isAdmin() || (bool) getAuth()->can(\Perms::$PAGE['DELETE'])) ) {
            abort(403, "You don't have permission to view this page");
        }

        $page = Page::findOrFail($id);
        $page = $this->repo_service->removeExistsResource( $page );
        $page->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);

        return redirect()->route(admin_route('page.index'));
    }

    public function deleteSource(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page = $this->repo_service->removeExistsResource( $page );
        $page->save();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Source has been successfully deleted'
        ]);

        return redirect()->route(admin_route('page.edit'), $id);
    }
}
