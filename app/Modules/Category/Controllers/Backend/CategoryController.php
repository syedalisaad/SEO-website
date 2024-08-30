<?php namespace App\Modules\Category\Controllers\Backend;

use App\Models\Category;

use Illuminate\Http\Request;
use App\Modules\Category\Request\CategoryRequest;

use DataTables;

class CategoryController extends \App\Http\Controllers\AdminController
{
    protected $repo_service;

    public $module = 'Category';

    public function __construct( \App\Modules\Category\Respository\CategoryRespository $category_respository ) {
        $this->repo_service = $category_respository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CATEGORY['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'manage', $this->module ) );
    }

    public function ajaxManageable(Request $request)
    {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );

        $data = Category::orderBy($order_cols,$order_by)->orderByDesc('updated_at');

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';

            if( isAdmin() || getAuth()->can(\Perms::$CATEGORY['UPDATE']) ) {
                $action .= '<a href="'.route(admin_route('category.edit'), [$row->id]).'" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
            }

            if( isAdmin() || getAuth()->can(\Perms::$CATEGORY['DELETE']) ) {
                $action .= '<a href="javascript:void(0)" data-href="'.route(admin_route('category.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }

            return $action?:'-';
        })
        ->addIndexColumn()
        ->addColumn( 'source_image', function( $row ) {
            return '<img src="' . $row->image_url . '" width="50" height="50" />';
        })
        ->editColumn('is_active', function($row) {
            return $row->status;
        })
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
    public function create() {

        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CATEGORY['ADD'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'form', $this->module ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->repo_service->createOrUpdate( $request, new Category );

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
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CATEGORY['UPDATE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $data = Category::findOrFail($find_id);

        return view( admin_module_view( 'form', $this->module ), compact('data') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $find_id)
    {
        $model = Category::findOrFail($find_id);

        $this->repo_service->createOrUpdate( $request, $model );

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route( admin_route('category.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id )
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$CATEGORY['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $delete = Category::findOrFail($id);
        $delete->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);
        return redirect( route(admin_route('category.index')) );
    }

    public function getRetrieveCategoryById( $level = null, $category_id = 0 )
    {
        $categories = Category::getParentCategories($category_id);

        return response()->json([
            'status' => true,
            'message' => 'Retrieve categories by level: ' . $level . ', category: ' . $category_id,
            'collection' => $categories
        ]);
    }
}
