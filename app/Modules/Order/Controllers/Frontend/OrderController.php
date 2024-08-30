<?php namespace App\Modules\Order\Controllers\Frontend;

use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use \App\Modules\Order\Respository\OrderRespository;

class OrderController extends \App\Http\Controllers\Controller
{
    protected $repo_service;

    public function __construct( \App\Modules\Order\Respository\OrderRespository $order_respository ) {
        $this->repo_service = $order_respository;
    }

    public function getOrdersList( Request $request)
    {
        $user = Auth::user();

        $orders = Order::whereUserId( $user->id )->where('for_order_status', '<>', OrderRespository::$FOR_ORDER_STATUS_CART)->latest()->get();

        //code [view]
    }
}
