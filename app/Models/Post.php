<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    static public $storage_disk = 'posts';

    static public $TYPE_OF_BLOG = 'blog';
    static public $TYPE_OF_NEWS = 'news';

    public static function boot() {

        parent::boot();

        self::saving( function( $activity ) {
            $activity->slug = \Str::slug( $activity->name, '-' );
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'short_desc', 'description', 'source_image', 'type_of', 'extras', 'seo_metadata'
    ];

    protected $dates = ['post_date'];

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
        return $q->where( 'posts.is_active', 1 );
    }

    public function scopeIsPost( $q ) {
        return $q->where( 'posts.type_of', self::$TYPE_OF_POST );
    }

    public function scopeIsBlog( $q ) {
        return $q->where( 'posts.type_of', self::$TYPE_OF_BLOG );
    }

    public function scopeIsNews( $q ) {
        return $q->where( 'posts.type_of', self::$TYPE_OF_NEWS );
    }

    public function getStatusAttribute() {
        return $this->is_active == 1 ? 'Active' : 'De-Active';
    }

    public function getImageUrlAttribute() {
        return media_storage_url( self::$storage_disk . '/' . ( $this->source_image ?: '-' ) );
    }

    public function getPostUrlAttribute() {

        switch ( $this->type_of )
        {
            case Post::$TYPE_OF_NEWS:
                return route(front_route('news.single'), $this->slug);
            break;
            case Post::$TYPE_OF_BLOG:
                return route(front_route('blog.single'), $this->slug);
            break;
        }

        return 'javascript:void(0)';
    }

    public function getCategoryAttribute() {
        return $this->hasCategories()->first();
    }

    public static function getParents( $parent_id = 0 ) {
        return self::whereParentId( $parent_id )->get()->pluck( 'name', 'id' )->toArray();
    }

    public function tags() {
        return $this->hasMany( PostTag::class, 'post_id', 'id' );
    }

    /**
     * The categories that belong to the post.
     */
    public function hasCategories() {
        return $this->belongsToMany( Category::class, 'post_categories', 'post_id', 'category_id' );
    }

    public static function getBlogPosts()
    {
        $builder = Post::select('posts.*')->isBlog()->isActive()->latest('posts.created_at');
        $builder->leftJoin('post_tags AS pt', 'pt.post_id', '=', 'posts.id');

        if( request()->get( 'tag' ) ) {
            $builder->where( 'pt.tag_slug', request()->get( 'tag' ) );
        }

        $builder->groupBy('posts.id');

        return $builder->paginate();
    }
}
