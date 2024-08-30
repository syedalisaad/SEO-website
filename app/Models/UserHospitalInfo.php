<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHospitalInfo extends Model {
    protected $table = 'user_hospital_info';
    public $timestamps = false;
    static public $storage_disk = 'hospitals';
    protected $fillable = [
        'user_id',
        'hospital_id',
        'name',
        'short_desc',
        'description',
        'phone_number',
        'address',
        'ref_url',
        'logo_image',
        'right_image',
        'share_image',
        'extras',
        'is_approved',
        'is_publish',
        'video_one',
        'video_two',
        'video_three'
    ];
    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'extras' => 'array'
    ];

    public function getApprovedStatusAttribute() {
        return ( $this->is_approved == 1 ? 'Approved' : 'Un-Approved' );
    }

    public function getLogoImageUrlAttribute() {
        $storage = media_storage_url( self::$storage_disk . '/' . ( $this->logo_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getRightImageUrlAttribute() {
        $storage = media_storage_url( self::$storage_disk . '/' . ( $this->right_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }



    public function hospital() {
        return $this->belongsTo( Hospital::class, 'hospital_id', 'id' );
    }

    public function getImageUrlRightAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->right_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getImageUrlLogoAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->logo_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }
    public function getImageUrlShareAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->share_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getUrlVideoOneAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->video_one ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getUrlVideoTwoAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->video_two ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getUrlVideoThreeAttribute() {
        $storage = media_storage_url( Hospital::$storage_disk . '/' . ( $this->video_three ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }
}
