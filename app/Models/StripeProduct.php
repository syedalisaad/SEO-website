<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\StripeProductPrice;

class StripeProduct extends Model
{
    use SoftDeletes;

    /*
    * Packages details as of [Tier Pricing Sheet Draft 7-27-2021]
    *
   Premium:
   1. $649/month or $6,490.00/12 months for the price of 10.

   Premium Plus:
   1: Add One Video: $1,499/mo. $14,999.00 get 12 months for price of 10.
   2: Add Two Videos: $1,799/mo. $ 17,999.00 get 12 months for price of 10.
   3: Add Three Videos: $1,999/mo. $19,999.00 get 12 months for price of 10.

   */
   public static $package_details = [
       'package_premium'      => [
           'stripe_product_id' => 'prod_KUWpAhy5i98mYw',
           'monthly'           => [
               'add_ons' => [
                   '1_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium',
                       'price'                   => 649,
                       'stripe_product_price_id' => 'price_1JpXleJRU6R71bcg42byYgRM',
                       'content'                 => 'Add One Videos for $649/mo'
                   ],
               ],
               'price'   => 649
           ],
           'yearly'            => [
               'add_ons' => [
                   '1_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium',
                       'price'                   => 6490,
                       'stripe_product_price_id' => 'price_1JpYJbJRU6R71bcghnVAnHxa',
                       'content'                 => 'Add One Video(s) for $6,490/yr'
                   ],
               ],
               'price'   => 6490
           ]
       ],
       'package_premium_plus' => [
           'stripe_product_id' => '',
           'monthly'           => [
               'add_ons' => [
                   '1_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 1499,
                       'stripe_product_price_id' => 'price_1JpXl0JRU6R71bcgeNgcp5AP',
                       'content'                 => 'Add One Video(s) for $1,499/mo'
                   ],
                   '2_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 1799,
                       'stripe_product_price_id' => 'price_1JpYQRJRU6R71bcgGYULVPEj',
                       'content'                 => 'Add Two Video(s) for $1,799/mo'
                   ],
                   '3_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 1999,
                       'stripe_product_price_id' => 'price_1JpYQeJRU6R71bcg59oyekhU',
                       'content'                 => 'Add Three Video(s) for $1,999/mo'
                   ]
               ],
               'price'   => 1499
           ],
           'yearly'            => [
               'add_ons' => [
                   '1_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 14999,
                       'stripe_product_price_id' => 'price_1JpYPQJRU6R71bcgyo9jdw03',
                       'content'                 => 'Add One Video(s) for $14,999/yr'
                   ],
                   '2_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 17999,
                       'stripe_product_price_id' => 'price_1JpYQ6JRU6R71bcgsH0FijTS',
                       'content'                 => 'Add Two Video(s) for $17,999/yr'
                   ],
                   '3_videos' => [
                       'name'                    => 'video',
                       'pacakge_name'            => 'package_premium_plus',
                       'price'                   => 19999,
                       'stripe_product_price_id' => 'price_1JpYQsJRU6R71bcgNOabXoHK',
                       'content'                 => 'Add Three Video(s) for $19,999/yr'
                   ]
               ],
               'price'   => 14999
           ]
       ],
   ];

    protected $table = 'stripe_products';

    public function scopeIsGatwayMode( $q )
    {
        $gateway_mode = get_site_settings('payment_gateway')['stripe']['gateway_mode'] ?? \App\Models\Setting::$GATEWAY_MODE_LIVE;

        return $q->where( 'type_of_mode', $gateway_mode );
    }

    public static function getStripeProductsList()
    {
        $products = self::where('is_active', 1)->isGatwayMode()->get();

        if( $products->count() )
        {
            $data = [];
            foreach( $products as $row )
            {
                $product_name = $row->name;
                $product_slug = \Str::slug($product_name, '_');

                $data[ $product_slug ] = [
                    'stripe_product_id' => $row->stripe_product_price_id
                ];

                $prices = $row->prices;

                if( $prices->count() )
                {
                    foreach( $prices->groupBy('recurring') as $recurring )
                    {
                        $i=0;
                        foreach($recurring as $value)
                        {
                            $i++;
                            $recurring_slug = StripeProductPrice::$RECURRING_YEAR == $value->recurring ? 'yearly' : 'monthly';

                            $data[ $product_slug ][$recurring_slug]['add_ons'][ $i . '_videos'] = [
                                'name'                    => $value->name,
                                'pacakge_name'            => $product_slug,
                                'price'                   => $value->price,
                                'stripe_product_price_id' => $value->stripe_product_price_id,
                                'content'                 => $value->content ?: ''
                            ];
                        }
                        $data[ $product_slug ][$recurring_slug]['price'] = current($data[ $product_slug ][$recurring_slug]['add_ons'])['price'];
                    }
                }
            }

            return $data;
        }

        return [];
    }

    public function prices()
    {
        return $this->hasMany(StripeProductPrice::class, 'stripe_product_id');
    }
}
