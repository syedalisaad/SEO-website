<?php namespace App\Support\Traits;

use \App\Models\Product;
use \App\Models\Order;
use \App\Models\OrderDetail;

use Illuminate\Support\Facades\Auth;
use \App\Modules\Order\Respository\OrderRespository;
use Stripe\OrderItem;

trait ShoppingCartDatabaseTrait  {

    protected $repo_order_service;

	static public function addToCart( $item )
    {
        $quantity   = (int) ( $item['qty'] ?? 1 );

        $user       = Auth::user();
        $carts      = $user->user_cart_orders ? $user->user_cart_orders->order_items : collect([]);
        $exist_item = $carts->where( 'product_id', $item['product_id'] );

        if( $exist_item->count() ){
            //Single Item Added
            return false;
        }
        else
        {
            (new OrderRespository(new Order))->apiCartCreateOrder( $item );
        }

        return true;
    }

    static public function existsCartBucketItem( $item_id )
    {
        $user         = Auth::user();
        $shoppingcart = $user && $user->user_cart_orders ? $user->user_cart_orders->order_items : collect( [] );

        if( 1 > $shoppingcart->count() ) {
            return FALSE;
        }

        $exist_item = $shoppingcart->where('product_id', $item_id);

        return (bool) $exist_item->count();
    }

    static public function removeCartById( $item_id )
    {
        $user       = Auth::user();
        $order      = $user->user_cart_orders;
        $order_item = OrderDetail::where( [ 'order_id' => $order->id, 'product_id' => $item_id ] );

        if( is_null($order_item->first()) ) {
            return FALSE;
        }

        $order_item->delete();

        $order->total_amount = self::getCartTotal();
        $order->save();

        return TRUE;
    }

    static public function getContent()
    {
        $user  = Auth::user();

        if( !$user ) {
            return collect([]);
        }

        return ($user->user_cart_orders ? $user->user_cart_orders->order_items : collect());
    }

    static public function destroyCart()
    {
        $user  = Auth::user();
        $order = $user->user_cart_orders;

        OrderDetail::where('order_id', $order->id)->delete();

        return TRUE;
    }

    static public function getTotalTax()
    {
        return 0;
    }

    static public function getCartSubtotal()
    {
        $carts = self::getContent();

        if( $carts->count() )
        {
            return $carts->map(function($v){
                return ($v['cost_price'] * $v['qty']);
            })->sum();
        }

        return 0;
    }

    static public function getCartTotal()
    {
        $carts = self::getContent();

        if( $carts->count() )
        {
            $sub_total = self::getCartSubtotal();

            return $sub_total;
        }

        return 0;
    }

    static public function getCartTotalItems()
    {
        $carts = self::getContent();

        return count($carts);
    }
}
