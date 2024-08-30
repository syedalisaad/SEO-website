<?php namespace App\Modules\Order\Controllers\Frontend;

use App\Models\StripeProductPrice;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

use Auth;

class CartController extends \App\Http\Controllers\Controller
{
    public function postAddtoCart( Request $request )
    {
        $validator = \Validator::make( $request->all(), [
            'addon_video' => 'required|exists:stripe_product_details,stripe_product_price_id'
        ] );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $subscription = get_current_subscription();
        $product      = StripeProductPrice::where( 'stripe_product_price_id', $request->addon_video )->firstOrFail();

        $package_name_display = $product->name . ( isset($product->extras['video']) && $product->extras['video'] > 0 ? ' - '. $product->extras['video'] .' Video(s)' : '');

        if( $subscription )
        {
            $item_ids = $subscription->order_items->pluck('product_id')->toArray();

            if( in_array($product->id, $item_ids)) {
                $request->session()->flash( 'alert-message', [
                    'status'  => 'danger',
                    'message' => 'You have already subscribed to '. $package_name_display
                ]);

                return redirect()->back();
            }
        }

        if ( \ShoppingCart::existsCartBucketItem( $product->id ) ) {

            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'You already have this package in your card'
            ] );

            return redirect()->back();
        }

        if ( auth()->user() && auth()->user()->user_cart_orders ) {
            \ShoppingCart::destroyCart();
        }

        \ShoppingCart::addToCart( array(
            'product_id' => $product->id,
            'price'      => $product->price,
            'qty'        => 1
        ) );

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => '"' . $package_name_display. '" package has been added to your cart'
        ] );

        return redirect()->route( front_route( 'user.payment' ) );
    }

    public function deleteCartItemByProduct( Request $request, $product_id ) {
        $product = StripeProductPrice::whereId( $product_id )->first();
        if ( is_null( $product ) ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'Package Item does not exists.'
            ] );

            return redirect()->back();
        }
        $success = \ShoppingCart::removeCartById( $product->id );
        if ( ! $success ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'danger',
                'message' => 'Your item does not exist in the cart.'
            ] );

            return redirect()->back();
        }
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Package has been deleted from your cart'
        ] );

        return redirect()->route( front_route( 'user.packages' ) );
    }

    public function getEmptyShoppingCart( Request $request ) {
        \ShoppingCart::destroyCart();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your shopping cart is empty'
        ] );

        return redirect()->back();
    }
}
