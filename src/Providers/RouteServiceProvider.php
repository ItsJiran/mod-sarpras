<?php

namespace Module\Infrastructure\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        // $domain = Cache::rememberForever('infrastructure-domain', function() {
        //    try {
        //        return optional(DB::table('system_modules')->where('slug', 'infrastructure')->first())->domain ?: 'backend';
        //    } catch (\Exception $e) {
        //        return 'backend';
        //    }
        // });

        // $prefix = Cache::rememberForever('infrastructure-prefix', function() {
        //    try {
        //        return optional(DB::table('system_modules')->where('slug', 'infrastructure')->first())->prefix ?: null;
        //    } catch (\Exception $e) {
        //        return null;
        //    }
        // });
        
        // Route::domain($domain . '.' . env('APP_URL'))
        //     ->middleware('web')
        //     ->prefix($prefix)
        //     ->namespace('Module\Infrastructure\Http\Controllers')
        //     ->group(__DIR__ . '/../../routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        $domain = Cache::rememberForever('infrastructure-domain', function() {
            try {
                return optional(DB::table('system_modules')->where('slug', 'infrastructure')->first())->domain ?: 'backend';
            } catch (\Exception $e) {
                return 'backend';
            }
        });

        $prefix = Cache::rememberForever('infrastructure-prefix', function() {
            try {
                return optional(DB::table('system_modules')->where('slug', 'infrastructure')->first())->prefix ?: null;
            } catch (\Exception $e) {
                return null;
            }
        });
        
        Route::domain($domain . '.' . env('APP_URL'))
            ->prefix($prefix . '/api')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace('Module\Infrastructure\Http\Controllers')
            ->group(__DIR__ . '/../../routes/api.php');
    }
}
