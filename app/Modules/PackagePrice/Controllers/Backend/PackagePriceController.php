<?php namespace App\Modules\PackagePrice\Controllers\Backend;

use App\Models\Page;
use App\Models\StripeProduct;
use App\Models\StripeProductPrice;
use Illuminate\Http\Request;
use App\Modules\Page\Request\PageRequest;
use DataTables;

class PackagePriceController extends \App\Http\Controllers\AdminController {
    protected $repo_service;
    public $module = 'PackagePrice';

    public function __construct( \App\Modules\Page\Respository\PageRespository $page_respository ) {
        $this->repo_service = $page_respository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( admin_module_view( 'index', $this->module ) );
    }

    public function ajaxManageable()
    {
        $data = StripeProduct::latest();

        return Datatables::of( $data )
         ->addColumn( 'action', function( $row ) {
            return $action = ' <a href="' . route( admin_route( 'packageprice.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-address-card"></i></a> ';
        })
         ->addIndexColumn()
         ->filterColumn( 'is_active', function( $query, $keyword ) {
            $query->where( 'is_active', (int) ( strpos( 'active', strtolower( $keyword ) ) !== false ) );
        })
         ->editColumn( 'is_active', function( $row ) {
            return $row->is_active;
        })
         ->editColumn( 'created_at', function( $row ) {
            return admin_datetime_format( $row->created_at, true );
        })
         ->rawColumns( [ 'action' ] )
         ->make( true );
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$PAGE['ADD'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }

        return view( admin_module_view( 'form', $this->module ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( PageRequest $request ) {
        $this->repo_service->createOrUpdate( $request, new Page );
        //Redirection when you choose button
        $route_action = route( admin_route( $request->formsubmit ) );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully added'
        ] );

        return redirect( $route_action );
    }

    public function show( $id ) {

        $data                 = StripeProduct::where( 'id', $id )->first();
        $stripe_price_monthly = StripeProductPrice::where( 'stripe_product_id', $data->id )->get();
        $stripe_price_yearly  = StripeProductPrice::where( 'stripe_product_id', $data->id )->get();

        return view( admin_module_view( 'show', $this->module ), compact( 'data', 'stripe_price_monthly', 'stripe_price_yearly' ) );
    }

    /**
     * show create price form.
     *
     * @param string $product_stripe_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddPrice( $product_stripe_id ) {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$PAGE['UPDATE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }
        $data = StripeProduct::where( 'stripe_poduct_id', $product_stripe_id )->first();

        return view( admin_module_view( 'price.create-price-product', $this->module ), compact( 'data' ) );
    }

    /**
     * create new price in product.
     * @return \Illuminate\Http\Response
     */
    public function getCreatePrice( Request $request )
    {
        \Stripe\Stripe::setClientId($stripe_info['client_id']);
        \Stripe\Stripe::setApiKey($stripe_info['client_secret']);

        $stripe = new \Stripe\StripeClient( $stripe_info['client_id'] );

        $array = $stripe->prices->create( [
            'unit_amount' => $request->price * 100,
            'currency'    => 'usd',
            'product'     => $request->product_stripe_id,
        ]);

        $stripe                          = new StripeProductPrice;
        $stripe->stripe_product_id       = $request->product_id;
        $stripe->stripe_product_price_id = $array->id;
        $stripe->price                   = $request->price;
        $stripe->recurring               = $request->recurring;
        $stripe->is_active               = $request->is_active;
        $stripe->save();

        $route_action = route( admin_route( $request->formsubmit ) );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully added'
        ] );

        return redirect( $route_action );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( PageRequest $request, $find_id )
    {
        $model = Page::findOrFail( $find_id );
        $this->repo_service->createOrUpdate( $request, $model );

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully updated'
        ]);
        return redirect()->route( admin_route( 'packageprice.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id ) {
        if ( true !== ( isAdmin() || (bool) getAuth()->can( \Perms::$PAGE['DELETE'] ) ) ) {
            abort( 403, "You don't have permission to view this page" );
        }
        $page = Page::findOrFail( $id );
        $page = $this->repo_service->removeExistsResource( $page );
        $page->delete();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Record has been successfully deleted'
        ] );

        return redirect()->route( admin_route( 'page.index' ) );
    }

    public function deleteSource( Request $request, $id ) {
        $page = Page::findOrFail( $id );
        $page = $this->repo_service->removeExistsResource( $page );
        $page->save();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Source has been successfully deleted'
        ] );

        return redirect()->route( admin_route( 'page.edit' ), $id );
    }
}
