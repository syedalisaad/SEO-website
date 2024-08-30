<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    static $storage_disk = 'categories';

	public static function boot()
	{
		parent::boot();

        self::saving( function($activity) {
            $activity->slug = \Str::slug($activity->name, '-');
        });
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'parent_id', 'name', 'slug', 'short_desc', 'is_active', 'extras', 'seo_metadata'
    ];

    protected $appends = [
        'image_url', 'created_date'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'slug', 'short_desc', 'image_url', 'created_date'];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
   protected $casts = [
       'extras'       => 'array',
       'seo_metadata' => 'array',
       'created_at'   => 'date:Y-m-d h:i:s',
       'updated_at'   => 'date:Y-m-d h:i:s',
   ];

    public function scopeIsActive( $q ) {
        return $q->where( 'is_active', 1 );
    }

    public function getStatusAttribute( $value ) {
        return $this->is_active == 1 ? 'Active' : 'De-Active';
    }

    public function getImageUrlAttribute()
    {
        $storage = media_storage_url( self::$storage_disk . '/' . ( $this->source_image ?: '-' ), null, null, '' );

        return $storage ?: default_media_url();
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->format( 'F d, Y H:i A' );
    }

    public function parent() {
        return $this->hasOne( Category::class, 'id', 'parent_id' );
    }

    public static function getParentCategories( $parent_id = null ) {
        return self::whereParentId( $parent_id )->get()->pluck( 'name', 'id' )->toArray();
    }

    public function products() {
        return $this->belongsToMany( Product::class, ProductCategory::class, 'category_id', 'product_id' );
    }
}
