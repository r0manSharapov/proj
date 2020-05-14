<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Conta;
use App\Policies\PrivateAreaPolicy;
use App\Movimento;
use App\Policies\MovementsPolicy;

class AppServiceProvider extends ServiceProvider
{

    /**
     * The policy mapping foe the application.
     *
     * @var array
     */
    protected $policies = [
        Conta::class => PrivateAreaPolicy::class,
        Movimento::class => MovementsPolicy::class,

       // 'App\Conta' => 'App\Policies\PrivateAreaPolicy'
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
