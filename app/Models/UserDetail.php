<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'hospital_id', 'is_hospital_approved', 'is_publish', 'extras'
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'extras' => 'array'
    ];

    public function getHospitalStatusAttribute() {
        return ($this->is_hospital_approved == 1 ? 'Approved' : 'Un-Approved');
    }

    public function getAdditionalDetailAttribute() {
        return $this->extras ?? null;
    }

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function HospitalDetail() {
        return $this->hasOne( Hospital::class, 'id', 'hospital_id' );
    }

    public function hospital() {
        return $this->hasOne( Hospital::class, 'id', 'hospital_id' );
    }
}
