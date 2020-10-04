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

    public function __construct(NativeSessionUserProvider $provider, SessionRetriever $session, Dispatcher $dispatcher)
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

        $session = $this->session->retrieve();

        // Laravel implements a Chain of Responsibility on the Authentication process.
        // If this Guard cannot authenticate, we must return null to give room for
        // other Guards to attempt to authenticate the current request.
        if (! $session) {
            return null;
        }

        $user = $this->provider->retrieveByCredentials($session);

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
