<?php declare(strict_types=1);

namespace Tests\CustomerGauge\Session;

use CustomerGauge\Session\Contracts\UserFactory;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\CustomerGauge\Session\Fixtures\FakeDispatcher;
use Tests\CustomerGauge\Session\Fixtures\MyUserFactory;

abstract class TestCase extends BaseTestCase
{
    protected $container;

    protected function setUp(): void
    {
        $this->container = $container = Container::getInstance();

        $container->bind(UserFactory::class, MyUserFactory::class);

        $container->bind(Dispatcher::class, FakeDispatcher::class);
    }
}
