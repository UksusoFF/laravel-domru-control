<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\AppController;
use App\Http\Controllers\PlaceController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->registerRoutes();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function(Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }

    protected function registerRoutes(): void
    {
        Route::prefix('api/public/{account}')
            ->middleware([
                SubstituteBindings::class,
            ])
            ->group(function() {
                Route::get('open/{control}', [PlaceController::class, 'open'])->name('place.open');
                Route::get('snap/{control}', [PlaceController::class, 'snap'])->name('place.snap');
                Route::get('rtsp/{camera}', [PlaceController::class, 'rtsp'])->name('camera.rtsp');
            });

        Route::group([
            'middleware' => ['web'],
        ], function() {
            Route::get('{any?}', [AppController::class, 'app'])->where('any', '.*');
        });
    }
}
