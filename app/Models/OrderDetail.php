<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \App\Models\Setting;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'cost_price', 'sale_price', 'qty', 'variations', 'extras'
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'variations' => 'array',
        'extras' => 'array',
    ];

    public function getItemPriceAttribute()
    {
        return format_currency($this->cost_price);
    }

    public function getItemSalePriceAttribute()
    {
        return $this->sale_price . ' '.Setting::$DEFAULT_CURRENCY;
    }

    public function getItemSubTotalAttribute()
    {
        $total = ($this->cost_price*$this->qty);

        return $total . ' '.Setting::$DEFAULT_CURRENCY;
    }

    public function getExtraDetailAttribute() {
        return $this->extras ?? null;
    }

    public function getItemVideoVaultAttribute() {
        return $this->product;
    }

    public function product() {
        return $this->belongsTo( StripeProductPrice::class );
    }

    public function order() {
        return $this->belongsTo( Order::class );
    }


}
