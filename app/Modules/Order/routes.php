<?php

Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\Order\Controllers\Backend' )->group(function() {

    //For Orders
    Route::get('order/on-boards', 'OrderController@getOnboardManage')->name('order.onboard.manage');
    Route::get('order/ajax/on-boards', 'OrderController@ajaxOnboardManageable')->name('order.ajax.onboard.manageable');

    //For Refund Orders
    Route::get('order/refunds', 'OrderController@getRefundManage')->name('order.refund.manage');
    Route::get('order/ajax/refunds', 'OrderController@ajaxRefundManageable')->name('order.ajax.refund.manageable');

    //For Delivered Orders
    Route::get('order/delivered', 'OrderController@getDeliveredManage')->name('order.delivered.manage');
    Route::get('order/ajax/delivered', 'OrderController@ajaxDeliveredManageable')->name('order.ajax.delivered.manageable');

    Route::get('order/delete/{order_id}', 'OrderController@destroyOrder')->name('order.delete');
    Route::post('order/revoke/order', 'OrderController@postRevokeOrder')->name('order.revoke.submit');
    Route::resource('order', 'OrderController');

});

Route::name('front.cart.')->namespace('App\Modules\Order\Controllers\Frontend' )->group(function() {

    //For Shopping
   Route::post( 'add-to-cart', 'CartController@postAddtoCart' )->name('add_to_cart');
   Route::get( 'shopping-cart', 'CartController@getShoppingCart' )->name('view_cart');

   //For Shopping - Delete Items
   Route::get( 'cart/delete/cart-item/{product_id}', 'CartController@deleteCartItemByProduct' )->name('delete_item');
   Route::get( 'cart/empty-shopping-cart', 'CartController@getEmptyShoppingCart' )->name('empty_item');

    //For Checkout
    Route::post( 'checkout', 'CheckoutController@postCheckout' )->name('checkout');
});
