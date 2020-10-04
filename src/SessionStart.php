<?php declare(strict_types=1);

namespace CustomerGauge\Session;

final class SessionStart
{
    private $path;

    private $domain;

    private $secure = true;

    private $started = false;

    public function __construct(string $path, string $domain)
    {
        $this->path = $path;
        $this->domain = $domain;
    }

    public static function fake(): self
    {
        $instance = new self('', '');

        $instance->started = true;

        return $instance;
    }

    public function insecure(): self
    {
        $this->secure = false;

        return $this;
    }

    public function start()
    {
        if ($this->started) {
            return;
        }

        ini_set('session.gc_maxlifetime', '1800');
        ini_set('session.save_handler', 'redis');
        ini_set('session.save_path', $this->path);
        ini_set('session.cookie_domain', $this->domain);
        ini_set('session.cookie_secure', (string) $this->secure);
        ini_set('session.cookie_httponly', '1');

        session_start();

        $this->started = true;
    }
}
