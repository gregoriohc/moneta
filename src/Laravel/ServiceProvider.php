<?php

namespace Gregoriohc\Moneta\Laravel;

use Gregoriohc\Moneta\Moneta;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = $this->app->make('path.config');
        $this->publishes([__DIR__.'/../../config/moneta.php' => $configPath . '/moneta.php']);  
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/moneta.php', 'moneta');

        $this->app['moneta'] = $this->app->share(function ($app) {
            return new Moneta();
        });
    }
}
