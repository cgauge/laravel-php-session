<?php declare(strict_types=1);

namespace CustomerGauge\Session;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
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

        $this->app->bind(SessionRetriever::class, function () {
            $config = $this->app->make(Repository::class);
            $path = $config->get('auth.guards.php.storage');

            $domain = $config->get('auth.guards.php.domain');

            return new SessionRetriever($path, $domain);
        });
    }
}

