<?php namespace App\Models;

use App\Modules\Order\Respository\OrderRespository;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
//    use SoftDeletes, HasRoles, HasFactory;
    use HasRoles, HasFactory;

    static public $USER_ADMIN   = 0;
    static public $USER_TEAM    = 1;
    static public $USER_USER    = 2;

    static public $VERIFY_TOKEN_LENGTH  = 6; //change 6 to any length you want

    static public $storage_disk = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'email', 'password', 'phone', 'age','is_active', 'source_image', 'ip_address', 'verifytoken', 'user_type', 'extras', 'is_password_set'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $appends = [
        'role_permissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ip_address'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extras'            => 'array',
        'email_verified_at' => 'datetime',
        'created_at'        => 'date:Y-m-d h:i:s',
        'updated_at'        => 'date:Y-m-d h:i:s',
    ];

    public function scopeIsActive( $q ) {
        return $q->where( 'is_active', 1 );
    }

   public function scopeIsSuspend( $q ) {
       return $q->where( 'is_active', 0 );
   }

    public function scopeIsVerifyEmail( $q ) {
       return $q->where( 'email_verified_at', '<>', null );
   }

    public function scopeIsAwaiting( $q ) {
        return $q->whereNULL( 'email_verified_at');
    }

    public function scopeIsTeam( $q ) {
        return $q->where( 'user_type', self::$USER_TEAM )->where( 'email_verified_at', '<>', null );
    }

    public function scopeIsUser( $q ) {
        return $q->where( 'user_type', self::$USER_USER )->where( 'email_verified_at', '<>', null );
    }

    public function scopeIsAdmin( $q ) {
        return $q->where( 'user_type', self::$USER_ADMIN )->where( 'email_verified_at', '<>', null );
    }

    public function setPasswordAttribute( $password ) {
        return $this->attributes['password'] = bcrypt( $password );
    }

    public function setPhoneAttribute( $phone ) {
        return $this->attributes['phone'] = $phone ? ltrim( $phone, '+' ) : '';
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->format( 'F d, Y H:i A' );
    }

    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusAttribute() {
        return ($this->is_active == 1 ? 'Active' : 'De-Active');
    }

    public function getUserCandidateAttribute()
    {
        switch ( $this->user_type )
        {
            case self::$USER_ADMIN:
                return 'Admin';
            break;

            case self::$USER_TEAM:
                return 'Team';
            break;

            case self::$USER_USER:
                return 'User';
            break;
        }

        return '-';
    }

    public function getIsAdminAttribute() {
        return (bool) $this->user_type == self::$USER_ADMIN;
    }

    public function getIsDeveloperAttribute() {
        return $this->email == 'admin@koderlabs.com';
    }

    public function getIsUserAttribute() {
        return (bool) $this->user_type == self::$USER_USER;
    }

    public function getImageUrlAttribute()
    {
        $storage = media_storage_url( self::$storage_disk . '/' . ( $this->source_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getUserSubscriptionAttribute()
    {
        if( $this->user_order )
        {
            $order = $this->user_order;

            return $order->order_items->first()->product;
        }

        return false;
    }

    public function getRolePermissionsAttribute() {
        return getAuth()->getAllPermissions()->pluck( 'name' )->unique()->toArray();
    }

    public function getSubscriptionInfoHtmlAttribute() {

        $order = get_current_subscription( $this );
        if( $order )
        {
            $subscribe = $order->order_items->first()->product;

            return '<p> Billing <strong>'.$subscribe->name.'</strong>, <strong>'.$subscribe->format_recurry.'</strong> - Next invoice on <strong>'.\Carbon\Carbon::parse($order->transaction_detail['current_period_end'])->format('M d ').'</strong>
                for <strong>'.format_currency($order->total_amount).'</strong>
            </p>';
        }

        return '<p>Subscription has expired</p>';
    }

    public static function getLists() {
        return self::where( 'user_type', '<>', 0 )->whereNull('deleted_at')->select( [ \DB::raw( 'concat(first_name, " ", last_name) as name' ), 'id' ] )->get()->pluck( 'name', 'id' )->toArray();
    }

    public static function getUsersList() {
        return self::where( 'user_type', self::$USER_USER )->whereNull('deleted_at')->select( [ \DB::raw( 'concat(first_name, " ", last_name) as name' ), 'id' ] )->get()->pluck( 'name', 'id' )->toArray();
    }

    public static function getAdminList() {
        return self::where( 'user_type', self::$USER_ADMIN )->whereNull('deleted_at')->select( [ \DB::raw( 'concat(first_name, " ", last_name) as name' ), 'id' ] )->get()->pluck( 'name', 'id' )->toArray();
    }

    public static function getAdminEmailsList() {
        return self::where( 'user_type', self::$USER_ADMIN )->whereNull('deleted_at')->select([ 'email', \DB::raw( 'concat(first_name, " ", last_name) as name' ) ])->pluck('email', 'name')->toArray();
    }

    public function detail() {
        return $this->hasOne( UserDetail::class, 'user_id', 'id' );
    }

    public function user_cart_orders() {
        return $this->hasOne( Order::class, 'user_id', 'id' )->where('for_order_status', OrderRespository::$FOR_ORDER_STATUS_CART);
    }

    public function user_order() {
        return $this->hasOne( Order::class, 'user_id', 'id' )->where('for_order_status', OrderRespository::$FOR_ORDER_STATUS_DELIVERY);
    }
}
