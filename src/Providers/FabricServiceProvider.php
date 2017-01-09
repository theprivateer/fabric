<?php

namespace Privateer\Fabric\Providers;

use Illuminate\Support\ServiceProvider;


class FabricServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ( ! $this->app->routesAreCached()) {
            require __DIR__ . '/../../publish/routes/web.php';
        }

        $this->loadViewsFrom( __DIR__ . '/../../publish/resources/views', 'fabric');

        $this->publishes([
            __DIR__ . '/../../publish/resources/views' => resource_path('views/vendor/fabric'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../../publish/public' => public_path('vendor/fabric'),
        ], 'public');

        $this->loadMigrationsFrom( __DIR__ . '/../../publish/database/migrations');

        $this->publishes([
            __DIR__ . '/../../publish/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../publish/config/fabric.php' => config_path('fabric.php'),
            __DIR__ . '/../../publish/config/laravel-missing-page-redirector.php' => config_path('laravel-missing-page-redirector.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();
        $this->aliasManager();
        $this->commandManager();
    }

    private function registerManager()
    {
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        $this->app->register(\Laracasts\Flash\FlashServiceProvider::class);
        $this->app->register(\Spatie\MissingPageRedirector\MissingPageRedirectorServiceProvider::class);
        $this->app->register(\Watson\Sitemap\SitemapServiceProvider::class);
        $this->app->register(\Spatie\Menu\Laravel\MenuServiceProvider::class);
    }

    private function aliasManager()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('Html', \Collective\Html\HtmlFacade::class);
        $loader->alias('Flash', \Laracasts\Flash\Flash::class);
        $loader->alias('Sitemap', \Watson\Sitemap\Facades\Sitemap::class);
        $loader->alias('Menu', \Spatie\Menu\Laravel\MenuFacade::class);
    }

    private function commandManager()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Privateer\Fabric\Console\Commands\BootstrapSite::class
            ]);
        }
    }
}