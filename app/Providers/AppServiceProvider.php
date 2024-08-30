<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Utilities Helpers:: Register the application services.
        if( \File::isDirectory( app_path('Support/Helpers')) )
        {
            foreach ( glob(app_path('Support/Helpers/*.php')) as $file) {
                require_once( $file );
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Http\Request $request)
    {
        if ( ! empty( env( 'NGROK_URL' ) ) && $request->server->has( 'HTTP_X_ORIGINAL_HOST' ) ) {
            $this->app['url']->forceRootUrl( env( 'NGROK_URL' ) );
            $this->app['url']->forceScheme( 'https' );
        }
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        //
    }
}
