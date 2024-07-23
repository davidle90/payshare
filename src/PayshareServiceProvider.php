<?php

namespace davidle90\payshare;

use Illuminate\Support\ServiceProvider;

class PayshareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/payshare.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'payshare');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/payshare.php', 'payshare');

        // Register command
        //if($this->app->runningInConsole()){
        //    $this->command([
        //        DoSomething::class
        //    ]);
        //}
    }
}
