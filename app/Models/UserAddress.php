<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    static public $FOR_BILLING = 'billing';
    static public $FOR_SHIPPING = 'shipping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email', 'phone', 'address', 'country', 'state', 'city', 'zipcode', 'company', 'for_type', 'extras', 'ip_address', 'is_default'
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'extras' => 'array'
    ];

    public function scopeIsBilling( $q ) {
        return $q->where( 'for_type', self::$FOR_BILLING );
    }

    public function scopeIsShipping( $q ) {
        return $q->where( 'for_type', self::$FOR_SHIPPING );
    }

    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function user() {
        return $this->belongsTo( User::class );
    }
}
