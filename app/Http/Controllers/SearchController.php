<?php namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

use \App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $searchString = null)
    {
        $searchItems = $paginatedSearchResults = null;

        if($searchString != null)
        {
            /***
             * Pages with post
             */
            $pages = Page::isActive()->isMenu()->where( 'name', 'like', '%' . $searchString . '%' )->get();
            $posts = Post::isActive()->where( 'name', 'like', '%' . $searchString . '%' )->get();

            /***
             * Categories with post
             */
            $categories = Category::isActive()->whereHas('posts', function ($query) use ($searchString){
                $query->where('name', 'like', '%'.$searchString.'%');
                $query->where('is_active', 1);
            })
            ->with(['posts' => function($query) use ($searchString){
                $query->where('name', 'like', '%'.$searchString.'%');
                $query->where('is_active', 1);
            }])
            ->get();

            $combine_array = array_merge(
                $pages->toArray(),
                //$categories->toArray(),
                $posts->toArray()
            );

            //Create a new Laravel collection from the array data
            $collection = new Collection($combine_array);

            //Get current page form url e.g. &page=6
            $current_page = LengthAwarePaginator::resolveCurrentPage();

            //Define how many items we want to be visible in each page
            $per_page = 10;
            $offset   = ( ( $current_page - 1 ) * $per_page );

            //Create our paginator and pass it to the view
            $paginatedSearchResults = new LengthAwarePaginator(
                $collection->forPage($current_page, $per_page),
                $collection->count(),
                $per_page,
                $offset,
                ['path' => route( 'search',[ 'searchString' => $searchString ])]
            );
            $searchItems = $paginatedSearchResults->items();
        }

        return view( front_view('search'), compact('searchItems', 'searchString', 'paginatedSearchResults' ) );
    }
}
