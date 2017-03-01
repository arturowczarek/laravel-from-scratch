<?php

namespace App\Providers;

use App\Billing\Stripe;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.sidebar', function ($view) {
            $view->with('archives', \App\Post::archives());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        \App::singleton('App\Billing\Stripe', function () {
//            return new \App\Billing\Stripe(config('services.stripe.key'));
//        });
        $this->app->singleton(Stripe::class, function () {
            return new Stripe(config('services.stripe.key'));
        });
    }
}
