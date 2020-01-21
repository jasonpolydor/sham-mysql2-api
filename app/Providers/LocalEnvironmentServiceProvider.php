<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class LocalEnvironmentServiceProvider extends ServiceProvider
{
    /**
     * Service Providers only should be loaded in consoe mode.
     *
     * @var array
     */
    protected $consoleProviders = [
        \CrestApps\CodeGenerator\CodeGeneratorServiceProvider::class,
        \Laravel\Tinker\TinkerServiceProvider::class,
    ];

    /**
     * Service Providers only should be loaded in development.
     *
     * @var array
     */
    protected $localProviders = [
        \Barryvdh\Debugbar\ServiceProvider::class,
    ];

    /**
     * Facade aliases only should be loaded in development
     *
     * @var array
     */
    protected $facadeAliases = [
        //'Debugbar' => \Barryvdh\Debugbar\Facade::class,
    ];

    /**
     * Register Service Providers
     */
    protected function registerConsoleServiceProviders()
    {
        foreach ($this->consoleProviders as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register Service Providers
     */
    protected function registerServiceProviders()
    {
        foreach ($this->localProviders as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register Facade aliases
     * Base file Alias load is /config/app.php => aliases.
     */
    public function registerFacadeAliases()
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->facadeAliases as $alias => $facade) {
            $loader->alias($alias, $facade);
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment('local')) {
            $this->registerServiceProviders();
            $this->registerFacadeAliases();

            if ($this->app->runningInConsole()) {
                $this->registerConsoleServiceProviders();
                Schema::defaultStringLength(191);
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
