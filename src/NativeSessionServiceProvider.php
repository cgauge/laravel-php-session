<?php declare(strict_types=1);

namespace CustomerGauge\Session;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

final class NativeSessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        Auth::provider(NativeSessionUserProvider::class, function () {
            return $this->app->make(NativeSessionUserProvider::class);
        });

        Auth::extend(NativeSessionGuard::class, function (Container $app) {
            return $app->make(NativeSessionGuard::class);
        });
    }
}

