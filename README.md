[![Code Coverage](https://scrutinizer-ci.com/g/cgauge/laravel-php-session/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/cgauge/laravel-php-session/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cgauge/laravel-php-session/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/cgauge/laravel-php-session/?branch=main)

# Laravel PHP Session ⛔

This library provides a NativeSessionUserProvider for Laravel.

# Installation

```bash
composer require customergauge/session
```

# Usage

### Auth configuration

In the `auth.php` file, add the following settings:

Default Guard

```php
    'defaults' => [
        'guard' => 'php',
        'passwords' => 'users',
    ],
```

The new Guard configuration
```php
    'guards' => [
        'php' => [
            'driver' => \CustomerGauge\Session\NativeSessionGuard::class,
            'provider' => \CustomerGauge\Session\NativeSessionUserProvider::class,
            'domain' => '.app.mydomain.com',
            'storage' => 'tcp://my.redis.address:6379',
        ],
    ],
```

### Auth Middleware

Configure the `auth` middleware at `App\Http\Kernel` with `'auth:php'`

### UserFactory

The last thing you'll need is to provide your own implementation of `UserFactory` and register it in a ServiceProvider.

```
final class CognitoUserFactory implements UserFactory
{
    public function make(array $payload): ?Authenticatable
    {
        return new MyUserObject(
            $payload['username'],
            $payload['custom:my_custom_cognito_attribute'],
        );
    }
}
```

In the provider:
```
$this->app->bind(CustomerGauge\Session\Contracts\UserFactory, App\Auth\NativeSessionUserFactory::class);
```