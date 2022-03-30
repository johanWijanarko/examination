<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SiteHelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path(). '/Helpers/SiteHelpers.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
