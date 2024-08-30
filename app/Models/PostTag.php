<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table = 'post_tags';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'tag_name', 'tag_slug',
    ];

    public static function getLists()
    {
        return self::select( [\DB::raw('DISTINCT(tag_name) as tag_name'), 'tag_slug'] )->get()->pluck('tag_name', 'tag_slug')->toArray();
    }

    public static function getAllTags()
    {
        return self::select( \DB::raw('DISTINCT(tag_name)') )->get()->pluck('tag_name')->toArray();
    }
}
