<?php
namespace Kezeneilhou\CmsLaravel\Providers;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->app->make('Kezeneilhou\\CmsLaravel\\Controllers\\PostController');
        $this->app->make('Kezeneilhou\\CmsLaravel\\Controllers\\QuillUploadController');
        $this->publishes(
            [
            __DIR__ . '/../resources/views' => resource_path('views'),
            __DIR__ . '/../database/migrations' => database_path('migrations'),
            __DIR__.'/../controllers' => app_path('Http/Controllers'),
            __DIR__.'/../Models' => app_path('Models'),
            ],'laravel-cms');
    }

    public function register()
    {
        // Register package
    }
}