<?php

declare(strict_types=1);

namespace App\Orchid;

use Illuminate\Support\AggregateServiceProvider as ServiceProvider;

class AggregateServiceProvider extends ServiceProvider
{
    protected $providers = [
        PlatformProvider::class,
        RouteServiceProvider::class,
    ];
}
