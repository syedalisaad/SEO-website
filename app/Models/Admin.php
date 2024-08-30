<?php namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $table = 'users';

    static public $for_guard = 'admin';

    #protected $guarded = ['web'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'email', 'password', 'phone', 'age', 'source_image', 'ip_address', 'verifytoken', 'user_type', 'extras'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verifytoken', 'ip_address'
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
}
