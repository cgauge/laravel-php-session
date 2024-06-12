<?php declare(strict_types=1);

namespace CustomerGauge\Session;

use BadMethodCallException;
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

    /**
     * @inheritdoc
     * @phpstan ignore
     */
    public function validateCredentials(LaravelAuthenticatable $user, array $credentials)
    {
        throw new BadMethodCallException('Not implemented');
    }

    /**
     * @inheritdoc
     * @phpstan ignore
     */
    public function retrieveById($identifier)
    {
        throw new BadMethodCallException('Not implemented');
    }

    /**
     * @inheritdoc
     * @phpstan ignore
     */
    public function retrieveByToken($identifier, $token)
    {
        throw new BadMethodCallException('Not implemented');
    }

    /**
     * @inheritdoc
     * @phpstan ignore
     */
    public function updateRememberToken(LaravelAuthenticatable $user, $token)
    {
        throw new BadMethodCallException('Not implemented');
    }

    /**
     * @inheritdoc
     * @phpstan ignore
     */
    public function rehashPasswordIfRequired(LaravelAuthenticatable $user, array $credentials, bool $force = false)
    {
        throw new BadMethodCallException('Not implemented');
    }
}
