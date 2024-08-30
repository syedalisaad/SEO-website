<?php namespace App\Modules\Blog\Controllers\Frontend;

use \App\Models\Page;
use \App\Models\Post;

class BlogController extends \App\Http\Controllers\Controller
{
    public $module = 'Blog';

    /**
     * Show the application "Blogs"
     *
     */
    public function getIndex()
    {
        $data  = Page::isActive()->whereSlug( Page::$PAGE_BLOG )->firstOrFail();
        $blogs = Post::getBlogPosts();

        $seo_metadata = $data->seo_metadata ?? [];

        return view(frontend_module_view( 'blogs', $this->module ), compact('data', 'blogs', 'seo_metadata'));
    }

    /**
     * Show the application "Blogs"
     *
     */
    public function getSingle( $blog )
    {
        //$page = Page::isActive()->whereSlug( Page::$PAGE_BLOG )->firstOrFail();
        $post         = Post::where( 'slug', $blog )->firstOrFail();
        $posts        = Post::orderByRaw('RAND()')->isActive()->limit(3)->get();

        $seo_metadata = $data->seo_metadata ?? [];

        return view(frontend_module_view( 'single', $this->module ), compact('post', 'posts', 'seo_metadata'));
    }
}
