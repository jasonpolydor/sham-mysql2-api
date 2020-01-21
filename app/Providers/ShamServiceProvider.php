<?php

namespace App\Providers;

use App\AbsenceType;
use App\SysConfigValue;
use App\Observers\AbsenceTypeObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\Router;
use Collective\Html\FormBuilder as Form;

class ShamServiceProvider extends ServiceProvider
{

    /**
     * Service Providers for Development mode only.
     *
     * @var array
     */
    protected $devOnlyProviders = [
        \Barryvdh\Debugbar\ServiceProvider::class,
        \AlternativeLaravelCache\Provider\AlternativeCacheStoresServiceProvider::class,
    ];

    /**
     * Service Providers for Console mode only.
     *
     * @var array
     */
    protected $consoleProviders = [
        \CrestApps\CodeGenerator\CodeGeneratorServiceProvider::class,
        \Laravel\Tinker\TinkerServiceProvider::class,
    ];

    /**
     * Service Providers for 'GUI' mode.
     *
     * @var array
     */
    protected $nonConsoleProviders = [
        
        \App\Providers\ViewComposerServiceProvider::class,
        \Collective\Html\HtmlServiceProvider::class,
        \App\Providers\CalendarEventServiceProvider::class,
        \MaddHatter\LaravelFullcalendar\ServiceProvider::class,
    ];

    /**
     * Facade aliases for Development mode only
     *
     * @var array
     */
    protected $devFacadeAliases = [
        //'Debugbar' => \Barryvdh\Debugbar\Facade::class,
    ];

    /**
     * Facade aliases for 'GUI' mode
     *
     * @var array
     */
    protected $nonConsoleFacadeAliases = [
        
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
    ];

    public function boot()
    {
        AbsenceType::observe(AbsenceTypeObserver::class);
        
        if (App::environment('local')) {
            $this->registerDevOnlyServiceProviders();
            $this->registerDevOnlyFacadeAliases();
        }

        if ($this->app->runningInConsole()) {
            $this->registerConsoleServiceProviders();
            //Schema::defaultStringLength(191);
        } else {
            $this->registerNonConsoleServiceProviders();
        }
    }

    public function register()
    {
        $this->app->singleton('settings', function ($app) {
            return $app['cache']->remember('site.settings', 120, function () {
                return SysConfigValue::pluck('value', 'key')->toArray();
            });
        });

        if (!Router::hasMacro('mediaResource')) {
            $this->registerMacro();
        }

        if (!$this->app->runningInConsole()) {
            Form::macro('groupRelationSelect', 
                function ($name, $collection, $relation, $groupName = 'name', $optName = 'name', $optValue = 'id', $selected = null, $attributes = []) 
                {
                    $groups = [];
                    foreach ($collection as $model) {
                        foreach($model->$relation as $rel) {
                            if(!empty($model->$groupName) && !empty($rel->$optValue)){
                                $groups[$model->$groupName][$rel->$optValue] = $rel->$optName;
                            }
                        }
                    }

                    return Form::select($name, $groups, $selected, $attributes);
                }
            );

            Form::macro('groupSelect', 
                function ($name, $collection, $relation, $groupName = 'name', $optName = 'name', $optValue = 'id', $selected = null, $attributes = []) 
                {
                    $groups = [];
                    foreach ($collection as $model) {
                        if(!empty($model->$groupName) && !empty($model->$optValue)){
                            $groups[$model->$groupName][$model->$optValue] = $model->$optName;
                        }
                    }

                    return Form::select($name, $groups, $selected, $attributes);
                }
            );
        }

    }

    /**
     * Register Service Providers
     */
    private function registerConsoleServiceProviders()
    {
        foreach ($this->consoleProviders as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register Service Providers
     */
    private function registerNonConsoleServiceProviders()
    {
        foreach ($this->nonConsoleProviders as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register Service Providers
     */
    private function registerDevOnlyServiceProviders()
    {
        foreach ($this->devOnlyProviders as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register Development mode Facade aliases
     * Base file Alias load is /config/app.php => aliases.
     */
    private function registerDevOnlyFacadeAliases()
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->devFacadeAliases as $alias => $facade) {
            $loader->alias($alias, $facade);
        }
    }

    private function registerMacro()
    {
        Router::macro('mediaResource', function ($module, $only = [], $options = []) {
            $onlyOptions = count($only) ? ['only' => $only] : [];
            $controllerNameArray = collect(explode('.', $module))->map(function ($name) {
                return studly_case($name);
            });
            $lastName = $controllerNameArray->pop();
            $controllerName = $controllerNameArray->map(function ($name) {
                return str_singular($name);
            })->push($lastName)->push('Controller')->implode('');
            Router::resource($module, $controllerName, array_merge($onlyOptions, $options));
        });
    }

}