<?php declare(strict_types=1);

namespace CustomerGauge\Session;

use CustomerGauge\Session\Contracts\UserFactory;
use Illuminate\Contracts\Auth\Authenticatable as LaravelAuthenticatable;
use Illuminate\Contracts\Auth\UserProvider;

final class NativeSessionUserProvider implements UserProvider
{
    private $factory;

    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

    public function retrieveByCredentials(array $session)
    {
        return $this->factory->make($session);
    }

    /** @phpstan-ignore-next-line */
    public function retrieveById($identifier)
    {}

    /** @phpstan-ignore-next-line */
    public function retrieveByToken($identifier, $token)
    {}

    public function updateRememberToken(LaravelAuthenticatable $user, $token)
    {}

    /** @phpstan-ignore-next-line */
    public function validateCredentials(LaravelAuthenticatable $user, array $credentials)
    {}
}