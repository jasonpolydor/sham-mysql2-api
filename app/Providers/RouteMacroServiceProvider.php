<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class RouteMacroServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!Router::hasMacro('mediaResource')) {
            $this->registerMacro();
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