<?php

namespace TestImgApi;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TestImgApi\Services\TokenService;

class TestImgApiServiceProvider extends ServiceProvider
{
    const NAMESPACE_CR = 'TestImgApi\Http\Controllers';
    const PREFIX_PACKAGE = 'tia';

    public function register()
    {
        // ---
        $this->mergeConfigFrom(realpath(__DIR__ . '/../config/' . self::PREFIX_PACKAGE . '.php'), self::PREFIX_PACKAGE);

        // ---
        $this->app->bind(Contracts\ImageInterface::class, Services\ImageService::class);
        $this->app->bind(Contracts\UsersDataInterface::class, Services\UsersDataService::class);
        $this->app->bind(Contracts\UserItemInterface::class, Services\UserItemService::class);
        $this->app->bind(Contracts\UserItemInterface::class, function ($app, $params) {
            return new Services\UserItemService($params['item'] ?? null);
        });

        $this->app->singleton(Contracts\TokenInterface::class, function ($app) {
            return new TokenService();
        });

    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('token.auth', Http\Middleware\TokenAuth::class);


        \Illuminate\Pagination\Paginator::useBootstrapFive();
        // ---
        $this->publishes([
            __DIR__ . '/../config/' . self::PREFIX_PACKAGE . '.php' => config_path(self::PREFIX_PACKAGE . '.php')
        ], 'config');

        // ---
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        // ---
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', self::PREFIX_PACKAGE);
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang/');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/' . self::PREFIX_PACKAGE),
        ]);

        // ---
        $this->loadViewsFrom([
            __DIR__ . '/../resources/views/custom',
            __DIR__ . '/../resources/views'
        ], self::PREFIX_PACKAGE);
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/' . self::PREFIX_PACKAGE),
        ]);

        // ---
        $this->publishes([
            __DIR__.'/../package.json' => base_path('package.testimgapi.json'),
        ], self::PREFIX_PACKAGE . '-dependencies');

        // ---
        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/' . self::PREFIX_PACKAGE),
            __DIR__.'/../resources/sass' => resource_path('sass/vendor/' . self::PREFIX_PACKAGE),
        ], self::PREFIX_PACKAGE);

        // ---
        if (!$this->app->routesAreCached()) {
            $this->mapWebRoutes();
        }

        // ---
        $this->setFrontComponents();

    }

    protected function mapWebRoutes()
    {
        Route::name(self::PREFIX_PACKAGE . '.')
            ->namespace(self::NAMESPACE_CR)
            ->middleware(['web'])
            ->group(function ($router) {
                require __DIR__ . '/routes/web.php';
            });

        Route::name(self::PREFIX_PACKAGE . '.')
            ->prefix('api/v1')
            ->namespace(self::NAMESPACE_CR)
            ->middleware(['api'])
            ->group(function ($router) {
                require __DIR__ . '/routes/api.php';
            });
    }

    protected function setFrontComponents()
    {
        Blade::component(self::PREFIX_PACKAGE . '-table', \TestImgApi\View\Components\TableShow::class);
        Blade::component(self::PREFIX_PACKAGE . '-formadd', \TestImgApi\View\Components\FormAdd::class);
    }

}
