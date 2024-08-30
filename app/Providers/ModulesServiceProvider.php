<?php namespace App\Providers;

/**
* ServiceProvider
*
* The service provider for the modules. After being registered
* it will make sure that each of the modules are properly loaded
* i.e. with their routes, views etc.
*
* @author Junaid Ahmed <xunaidahmed@live.com>
* @package App\Modules
* @url https://kamranahmed.info/blog/2015/12/03/creating-a-modular-application-in-laravel/
*/
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $storage_disk = __DIR__.'/../Modules';

        // For each of the registered modules, include their routes and Views
        $modules = config("module.modules");

        $module_default = config("module.default");

        foreach( $modules as $module )
        {
            // Load "routes" for each of the modules
            if(file_exists($storage_disk. '/' .$module.'/routes.php')) {
                include $storage_disk. '/' .$module.'/routes.php';
            }

            // Load "migrations" for each of the modules
            if(is_dir($storage_disk. '/' .$module.'/Database/Migrations')) {
                $migrations = array_merge([database_path('migrations')],[$storage_disk. '/' .$module.'/Database/Migrations']);
                $this->loadMigrationsFrom($migrations);
            }

            // Load "languages" for each of the modules
            if(is_dir($storage_disk. '/' .$module.'/Resources/lang')) {
                $this->loadTranslationsFrom($storage_disk. '/' .$module.'/Resources/lang', $module);
            }

            // Load "views" for each of the modules
            if(is_dir($storage_disk. '/' .$module.'/Resources/views')) {
                $this->loadViewsFrom($storage_disk. '/' .$module.'/Resources/views', $module);
            }
        }

        //Default Default Settings
       /* $this->loadViewsFrom($storage_disk. '/General/Resources/views', 'general_views');
        $this->loadViewsFrom($storage_disk. '/General/Resources/lang', 'general_langs');*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
