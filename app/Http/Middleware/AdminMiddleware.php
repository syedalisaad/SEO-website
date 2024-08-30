<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    protected $except_perms = [
        'dashboard'
    ];

    protected $policy_perms = [
        'index' => 'list'
    ];


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle( Request $request, Closure $next, $guard = 'admin' )
    {
        if ( ! auth()->guard( $guard )->check() )
        {
            $request->session()->flash( 'error', 'You must be an employee to see this page' );
            return redirect()->route(admin_route('login'));
        }

        return $next( $request );
    }
}

