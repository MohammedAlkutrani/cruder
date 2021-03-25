<?php

namespace Cruder;

use Cruder\Commands\Cruder;
use Illuminate\Support\ServiceProvider;

class CruderProvider extends ServiceProvider
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
        if($this->app->runningInConsole()){
            $this->commands(Cruder::class);
        }
    }
}
