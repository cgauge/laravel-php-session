<?php declare(strict_types=1);

namespace Tests\CustomerGauge\Session\Fixtures;

use CustomerGauge\Session\Contracts\UserFactory;
use Illuminate\Contracts\Auth\Authenticatable;

final class MyUserFactory implements UserFactory
{
    public function make(array $session): ?Authenticatable
    {
        if (isset($session['id'])) {
            return new MyUser();
        }

        return null;
    }
}
