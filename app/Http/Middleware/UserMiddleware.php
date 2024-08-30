<?php namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle( Request $request, Closure $next, $guard = 'user' ) {
        if ( auth()->user() ) {
            $user = User::where( 'id', auth()->user()->id )->whereNotNull( 'deleted_at' )->first();
            if ( $user ) {

                auth()->logout();


            }

        }
        if(!auth()->user())
            {
                return redirect( 'login' );
            }

        return $next( $request );
    }
}

