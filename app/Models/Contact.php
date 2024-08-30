<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'ip_address'
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
   protected $casts = [
       'created_at'    => 'date:Y-m-d h:i:s',
       'updated_at'    => 'date:Y-m-d h:i:s',
   ];
}
