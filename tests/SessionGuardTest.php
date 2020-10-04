<?php declare(strict_types=1);

namespace Tests\CustomerGauge\Session;

use CustomerGauge\Session\NativeSessionGuard;
use CustomerGauge\Session\SessionRetriever;
use Tests\CustomerGauge\Session\Fixtures\MyUser;

final class SessionGuardTest extends TestCase
{
    public function test_valid_session_will_authenticate_user()
    {
        $session = ['id' => 1];

        $retriever = SessionRetriever::fake($session);

        $guard = $this->container->make(NativeSessionGuard::class, ['session' => $retriever]);

        self::assertInstanceOf(MyUser::class, $guard->user());
    }

    public function test_invalid_session_will_return_null()
    {
        $retriever = SessionRetriever::fake([]);

        $guard = $this->container->make(NativeSessionGuard::class, ['session' => $retriever]);

        self::assertNull($guard->user());
    }
}
