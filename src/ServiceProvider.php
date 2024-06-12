<?php

declare(strict_types=1);

namespace GianTiaga\MoonshineCoordinates;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'gt-moonshine-coordinates'
        );
    }
}
