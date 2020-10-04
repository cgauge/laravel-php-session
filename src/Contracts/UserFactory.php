<?php declare(strict_types=1);

namespace CustomerGauge\Session\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserFactory
{
    public function make(array $session): ?Authenticatable;
}
