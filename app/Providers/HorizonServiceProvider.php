<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        //Horizon::routeSmsNotificationsTo(env('HORIZON_MOBILE'));
        Horizon::routeMailNotificationsTo(env('HORIZON_EMAIL'));
        //Horizon::routeSlackNotificationsTo(env('HORIZON_SLACK_URL'), '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                'nathanael@bjorkgard.se','secretary@jwapp.info',
            ]);
        });
    }
}
