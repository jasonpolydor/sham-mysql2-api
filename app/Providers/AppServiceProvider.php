<?php

namespace App\Providers;

use App\User;
use App\Macros\Routing\Router;
use App\Observers\UserObserver;
use DB;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Validator;

require_once app_path('Helpers/shamHelper.php');

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        $this->app->singleton('current_user', function ($app) {
            return $app['auth']->user();
        });

        Queue::after(function (JobProcessed $event) {
            DB::table('job_logs')->insert([
                'loggable_type' => $event->job->resolveName(),
                'message' => 'Job processed',
                'level' => 900,
                'context' => $event->job->resolveName(),
                'extra' => json_encode($event->job),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Router::registerMacros();

    }
}
