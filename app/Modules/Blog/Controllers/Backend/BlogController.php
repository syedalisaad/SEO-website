<?php namespace App\Modules\Blog\Controllers\Backend;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Http\Request;
use App\Modules\Blog\Request\BlogRequest;

use DataTables;

class BlogController extends \App\Http\Controllers\AdminController
{
    protected $repo_service;

    public $module = 'Blog';

    public function __construct( \App\Modules\Blog\Respository\BlogRespository $blog_respository ) {
        $this->repo_service = $blog_respository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$BLOG['LIST'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'manage', $this->module ) );
    }

    public function ajaxManageable( Request $request)
    {
        $sort_cols  = getColsByDataable( $request->input( 'columns' ), 'action' );
        $order_cols = ( $sort_cols[ $request->input( 'order.0.column' ) ] ?? 'created_at' );
        $order_by   = ( $request->input( 'order.0.dir' ) ?: 'desc' );

        //TODO:: Search not working another table
        $data = Post::select('posts.*')->isBlog()->orderBy($order_cols,$order_by)->orderByDesc('posts.updated_at');

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';
            if( isAdmin() || getAuth()->can(\Perms::$BLOG['UPDATE']) ) {
                $action .= '<a href="'.route(admin_route('blog.edit'), [$row->id]).'" class="btn btn-success btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
            }

            if( isAdmin() || getAuth()->can(\Perms::$BLOG['DELETE']) ) {
                $action .= '<a href="javascript:void(0)" data-href="'.route(admin_route('blog.delete'), [$row->id]).'" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            }

            if ( $row->post_url ) {
                $action .= ' <a href="'.$row->post_url.'" target="_blank" class="btn btn-info btn-sm "><i class="fas fa-desktop"></i></a>';
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
    public function create()
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$BLOG['ADD'] ) ) ) {
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
    public function store(BlogRequest $request)
    {
        $this->repo_service->createOrUpdate( $request, new Post );

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
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$BLOG['UPDATE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $data = Post::findOrFail($find_id);

        return view( admin_module_view( 'form', $this->module ), compact('data') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $find_id)
    {
        $model = Post::findOrFail($find_id);

        $this->repo_service->createOrUpdate( $request, $model );

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route( admin_route('blog.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id )
    {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$BLOG['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        $delete = Post::findOrFail($id);
        $delete->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);
        return redirect( route(admin_route('blog.index')) );
    }
}
