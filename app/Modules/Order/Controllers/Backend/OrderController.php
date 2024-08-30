<?php namespace App\Modules\Order\Controllers\Backend;

use Illuminate\Http\Request;

use DataTables;

use App\Models\Order;

class OrderController extends \App\Http\Controllers\AdminController
{
    protected $repo_service;

    public $module = 'Order';

    public function __construct( \App\Modules\Order\Respository\OrderRespository $order_respository ) {
        $this->repo_service = $order_respository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOnboardManage(Request $request)
    {
        return view( admin_module_view( 'onboard-manage', $this->module ) );
    }

    public function ajaxOnboardManageable()
    {
        $data = Order::onboardOrders()->latest();

        return Datatables::of($data)
        ->addColumn('action', function($row){

            $action = '';
            $action .= '<a href="javascript:void(0)" data-href="' . route( admin_route( 'order.delete' ), [ $row->id ] ) . '" class="btn btn-danger btn-sm const-del-records"><i class="fas fa-trash"></i></a>';
            $action .= ' <a href="' . route( admin_route( 'order.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';

            return $action ?: '-';
        })
        ->addColumn('total_items', function($row) {
            return $row->order_items_detail;
        })
        ->editColumn('user_id', function($row) {
            return $row->user->full_name;
        })
        ->editColumn('total_amount', function($row) {
            return $row->order_total_amount;
        })
        ->editColumn('shipping_amount', function($row) {
            return $row->order_shippment_amount;
        })
        ->editColumn('for_order_status', function($row) {
            return $row->order_status;
        })
        ->editColumn('for_order_type', function($row) {
            return $row->order_payment;
        })
        ->editColumn('created_at', function($row) {
            return admin_datetime_format($row->created_at, true);
        })
        ->rawColumns(['action', 'total_items'])
        ->make(true);
    }

    /**
     * Show the application "Refund Orders".
     *
     * @return \Illuminate\Http\Response
     */
    public function getRefundManage( Request $request )
    {
        return view( admin_module_view( 'refund-manage', $this->module ) );
    }

    public function ajaxRefundManageable()
    {
        $data = Order::refundOrders()->latest();

        return Datatables::of($data)
         ->addColumn('action', function($row){

             $action = '';

             if ( isAdmin() || getAuth()->can( \Perms::$ORDER['VIEW'] ) ) {
                 $action .= ' <a href="' . route( admin_route( 'order.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';
             }

             return $action ?: '-';
         })
         ->addColumn('total_items', function($row) {
             return $row->order_items_detail;
         })
         ->editColumn('user_id', function($row) {
             return $row->user->full_name;
         })
         ->editColumn('total_amount', function($row) {
             return $row->order_total_amount;
         })
         ->editColumn('shipping_amount', function($row) {
             return $row->order_shippment_amount;
         })
         ->editColumn('for_order_status', function($row) {
             return $row->order_status;
         })
         ->editColumn('created_at', function($row) {
             return admin_datetime_format($row->created_at, true);
         })
         ->rawColumns(['action', 'total_items'])
         ->make(true);
    }

    /**
     * Show the application "Delivered Orders".
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeliveredManage( Request $request )
    {
        return view( admin_module_view( 'delivered-manage', $this->module ) );
    }

    public function ajaxDeliveredManageable()
    {

        $data = Order::select('orders.*')->deliveredOrders()
        ->join('users AS u', 'u.id', '=', 'orders.user_id')->whereNull('u.deleted_at')
        ->join('order_details AS od', 'od.order_id', '=', 'orders.id')
        ->join('stripe_product_details AS p', 'p.id', '=', 'od.product_id')
        ->latest('orders.created_at');

        return Datatables::of($data)
         ->addColumn('action', function($row){

             $action = '';
             $action .= ' <a href="' . route( admin_route( 'order.show' ), [ $row->id ] ) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> ';

             return $action ?: '-';
         })
        ->filterColumn('user_id', function($query, $keyword) {
            $query->where( 'u.first_name', 'like', "%{$keyword}%" )->orWhere( 'u.last_name', 'like', "%{$keyword}%" );
        })
        ->filterColumn('total_items', function($query, $keyword) {
            $query->where( 'p.name', 'like', "%{$keyword}%" );
        })
         ->addColumn('total_items', function($row) {
             return $row->order_items_detail;
         })
         ->editColumn('user_id', function($row) {
             return $row->user->full_name;
         })
         ->editColumn('total_amount', function($row) {
             return $row->order_total_amount;
         })
         ->editColumn('shipping_amount', function($row) {
             return $row->order_shippment_amount;
         })
         ->editColumn('for_order_status', function($row) {
             return $row->order_status;
         })
         ->editColumn('created_at', function($row) {
             return admin_datetime_format($row->created_at, true);
         })
         ->rawColumns(['action', 'total_items'])
         ->make(true);
    }

    public function postRevokeOrder(Request $request)
    {
        $rules = \Validator::make( $request->all(), [
            'order_id'     => 'required|exists:orders,id',
            'order_status' => 'required',
            'order_note'   => 'required|max:255',
        ]);

        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }

        $order = Order::find( $request->order_id );
        $order->for_order_status = $request->order_status;
        $order->order_note       = $request->order_note;
        $order->save();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully updated'
        ]);
        return redirect()->route(admin_route('order.show'), [$order]);
    }

    public function show( $order_id )
    {
        $order = Order::findOrFail($order_id);

        $title = "Order #" . $order->id;
        $uriback = admin_route('order.onboard.manage');

        return view( admin_module_view( 'order-detail', $this->module ), compact('order', 'title', 'uriback') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Record has been successfully deleted'
        ]);

        return redirect()->route(admin_route('order.onboard.manage'));
    }
}
