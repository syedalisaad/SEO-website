<?php namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

/**
* ServiceProvider
*
* The service provider for the template setting. After being registered
* it will make sure that each of the modules are properly loaded
* i.e. with their service, views etc.
*
* @author Junaid Ahmed <xunaidahmed@live.com>
* @package App\Providers
* @url https://github.com/xunaidahmed
*/
class GlobalTemplateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $site_settings = [];

        if (\Schema::hasTable('settings')) {
            $site_settings = get_site_settings();
        }

        //For Frontend
        view()->composer('frontend.*', function($view) use($site_settings) {

            $settings = [
                'site_settings' => $site_settings,
            ];

            $view->with($settings);
        });

        //For Modules
        view()->composer('General::admin.master', function($view) use($site_settings) {
            $view->with('auth', Auth::guard('admin')->user());
        });

        //For Modules
        view()->composer('General::admin.*', function($view) use($site_settings) {
            $view->with('site_settings', $site_settings );
        });

        //For Default (Admin)
        view()->composer('admin.*', function($view) use($site_settings) {
            $view->with('site_settings', $site_settings );
        });

        view()->composer('vendor.mail.*', function($view) use($site_settings) {
            $view->with('site_settings', $site_settings );
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
