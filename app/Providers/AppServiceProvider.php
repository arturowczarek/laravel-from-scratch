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
            $archives = \App\Post::archives();
            $tags = \App\Tag::has('posts')->pluck('name');
            $view->with(compact('archives', 'tags'));
//            $view->with('archives', $archives);
//            $view->with('tags', $tags);
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
