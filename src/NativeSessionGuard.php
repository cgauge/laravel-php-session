<?php declare(strict_types=1);

namespace CustomerGauge\Session;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Events\Dispatcher;

final class NativeSessionGuard implements Guard
{
    use GuardHelpers;

    private $session;

    private $dispatcher;

    public function __construct(NativeSessionUserProvider $provider, SessionStart $session, Dispatcher $dispatcher)
    {
        $this->provider = $provider;
        $this->session = $session;
        $this->dispatcher = $dispatcher;
    }

    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $this->session->start();

        if (! isset($_SESSION)) {
            return null;
        }

        $user = $this->provider->retrieveByCredentials($_SESSION);

        if ($user) {
            $this->dispatcher->dispatch(new Authenticated('php-native-session', $user));

            $this->user = $user;
        }

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        return (bool) $this->provider->retrieveByCredentials($_SESSION);
    }
}
