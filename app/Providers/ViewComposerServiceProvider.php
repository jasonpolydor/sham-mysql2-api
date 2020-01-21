<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;


use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', 'App\Http\ViewComposers\AuthComposer');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
