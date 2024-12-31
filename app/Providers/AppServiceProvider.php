<?php

namespace App\Providers;

use Carbon\Carbon;
use Cmixin\BusinessTime;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BusinessTime::enable(Carbon::class,[
            'holidays'=>[
                'region'=>'br'
            ]
        ]);
    }
}
