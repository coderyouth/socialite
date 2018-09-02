# Authenticate with CoderYouth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coderyouth/socialite.svg?style=flat-square)](https://packagist.org/packages/coderyouth/socialite)
[![Total Downloads](https://img.shields.io/packagist/dt/coderyouth/socialite.svg?style=flat-square)](https://packagist.org/packages/coderyouth/socialite)

## Installation

### 1. Install the package via composer:

```bash
composer require coderyouth/socialite
```

### 2. Install the service provider

- Remove `Laravel\Socialite\SocialiteServiceProvider` from your `providers[]` array in `config\app.php` if you have added it already.

- Add `\SocialiteProviders\Manager\ServiceProvider::class` to your `providers[]` array in `config\app.php`.

For example:

``` php
'providers' => [
    // a whole bunch of providers
    // remove 'Laravel\Socialite\SocialiteServiceProvider',
    \SocialiteProviders\Manager\ServiceProvider::class, // add
];
```

* Note: If you would like to use the Socialite Facade, you need to [install it.](https://github.com/laravel/socialite)

### 3. Event Listener

* Add `SocialiteProviders\Manager\SocialiteWasCalled` event to your `listen[]` array  in `app/Providers/EventServiceProvider`.

* Add `'SocialiteProviders\\Imgur\\ImgurExtendSocialite@handle',` to the `SocialiteWasCalled` array.

For example:

```php
/**
 * The event handler mappings for the application.
 *
 * @var array
 */
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        \CoderYouth\Socialite\CoderYouthExtendSocialite::class,
    ],
];
```

### 4. Configuration setup

You will need to add an entry to the services configuration file so that after config files are cached for usage in production environment (Laravel command `artisan config:cache`) all config is still available.

#### Add to `config/services.php`.

```php
'coderyouth' => [
    'client_id' => env('CODERYOUTH_KEY'),
    'client_secret' => env('CODERYOUTH_SECRET'),
    'redirect' => env('CODERYOUTH_REDIRECT')
],
```

## Usage

* [Laravel docs on configuration](http://laravel.com/docs/master/configuration)

* You should now be able to use it like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::with('coderyouth')->redirect();
```

### Lumen Support

You can use Socialite providers with Lumen.  Just make sure that you have facade support turned on and that you follow the setup directions properly.

**Note:** If you are using this with Lumen, all providers will automatically be stateless since **Lumen** does not keep track of state.

Also, configs cannot be parsed from the `services[]` in Lumen.  You can only set the values in the `.env` file as shown exactly in this document.  If needed, you can also override a config (shown below).

### Stateless

* You can set whether or not you want to use the provider as stateless.

**Note:** If you are using this with Lumen, all providers will automatically be stateless since **Lumen** does not keep track of state.

```php
// to turn off stateless
return Socialite::with('coderyouth')->stateless(false)->redirect();

// to use stateless
return Socialite::with('coderyouth')->stateless()->redirect();
```

### Overriding a config

If you need to override the provider's environment or config variables dynamically anywhere in your application, you may use the following:

```php
$clientId = "secret";

$clientSecret = "secret";

$redirectUrl = "http://yourdomain.com/api/redirect";

$additionalProviderConfig = ['site' => 'meta.stackoverflow.com'];

$config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
return Socialite::with('coderyouth')->setConfig($config)->redirect();
```

### Retrieving the Access Token Response Body

Laravel Socialite by default only allows access to the `access_token`.  Which can be accessed
via the `\Laravel\Socialite\User->token` public property.  Sometimes you need access to the whole response body which
may contain items such as a `refresh_token`.

You can get the access token response body, after you called the `user()` method in Socialite, by accessing the property `$user->accessTokenResponseBody`;

```php
$user = Socialite::driver('coderyouth')->user();
$accessTokenResponseBody = $user->accessTokenResponseBody;
```

### Security

If you discover any security related issues, please email soy@miguelpiedrafita.com instead of using the issue tracker.

## Credits

- [Miguel Piedrafita](https://github.com/m1guelpf)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.