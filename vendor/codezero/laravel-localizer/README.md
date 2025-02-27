# Laravel Localizer

[![GitHub release](https://img.shields.io/github/release/codezero-be/laravel-localizer.svg?style=flat-square)](https://github.com/codezero-be/laravel-localizer/releases)
[![Laravel](https://img.shields.io/badge/laravel-10-red?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/packagist/l/codezero/laravel-localizer.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/actions/workflow/status/codezero-be/laravel-localizer/run-tests.yml?style=flat-square&logo=github&logoColor=white&label=tests)](https://github.com/codezero-be/laravel-localizer/actions)
[![Code Coverage](https://img.shields.io/codacy/coverage/ad6fcea152b449d380a187a375d0f7d7/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/laravel-localizer)
[![Code Quality](https://img.shields.io/codacy/grade/ad6fcea152b449d380a187a375d0f7d7/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/laravel-localizer)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/laravel-localizer.svg?style=flat-square)](https://packagist.org/packages/codezero/laravel-localizer)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R3UQ8V)

Automatically detect and set an app locale that matches your visitor's preference.

- Define your supported locales and match your visitor's preference
- Uses the most common locale [detectors](#detectors) by default
- Uses the most common locale [stores](#stores) by default
- Easily create and add your own detectors and stores

## ✅ Requirements

- PHP >= 7.1
- Laravel >= 5.6

## 📦 Install

Install this package with Composer:

```bash
composer require codezero/laravel-localizer
```

Laravel will automatically register the ServiceProvider.

## 🧩 Add Middleware

Add the middleware to the `web` middleware group in `app/Http/Kernel.php`.
Make sure to add it after `StartSession` and before `SubstituteBindings`:

```php
protected $middlewareGroups = [
    'web' => [
        \Illuminate\Session\Middleware\StartSession::class, // <= after this
        //...
        \CodeZero\Localizer\Middleware\SetLocale::class,
        //...
        \Illuminate\Routing\Middleware\SubstituteBindings::class, // <= before this
    ],
];
```

In Laravel 6.x and higher, you also need to add the middleware to the `$middlewarePriority` array in `app/Http/Kernel.php`
to trigger it in the correct order:

```php
protected $middlewarePriority = [
    \Illuminate\Session\Middleware\StartSession::class, // <= after this
    //...
    \CodeZero\Localizer\Middleware\SetLocale::class,
    //...
    \Illuminate\Routing\Middleware\SubstituteBindings::class, // <= before this
];
```

If you don't see the `$middlewarePriority` array in your kernel file,
then you can copy it over from the parent class `Illuminate\Foundation\Http\Kernel`.

## ⚙️ Configure

### Publish Configuration File

```bash
php artisan vendor:publish --provider="CodeZero\Localizer\LocalizerServiceProvider" --tag="config"
```

You will now find a `localizer.php` file in the `config` folder.

### Configure Supported Locales

Add any locales you wish to support to your published `config/localizer.php` file:

```php
'supported-locales' => ['en', 'nl'];
```

You can also use one or more custom slugs for a locale:

```php
'supported-locales' => [
    'en' => 'english-slug',
    'nl' => ['dutch-slug', 'nederlandse-slug'],
];
```

Or you can use one or more custom domains for a locale:

```php
'supported-locales' => [
    'en' => 'english-domain.test',
    'nl' => ['dutch-domain.test', 'nederlands-domain.test'],
];
```

## 🔍 Detectors

By default, the middleware will use the following detectors to check for a supported locale in:

1. A custom route action
2. The URL (domain or slug)
3. A main omitted locale
4. The authenticated user model
5. The session
6. A cookie
7. The browser
8. The app's default locale

Update the `detectors` array to choose which detectors to run and in what order.

> You can create your own detector by implementing the `\CodeZero\Localizer\Detectors\Detector` interface
> and add a reference to it in the config file. The detectors are resolved from Laravel's IOC container,
> so you can add any dependencies to your constructor.

## 💾 Stores

The first supported locale that is returned by a detector will automatically be stored in:

- The session
- A cookie
- The app locale

Update the `stores` array to choose which stores to use.

> You can create your own store by implementing the `\CodeZero\Localizer\Stores\Store` interface 
> and add a reference to it in the config file. The stores are resolved from Laravel's IOC container, 
> so you can add any dependencies to your constructor.

## 🛠️ More Configuration (optional)

### ☑️ `omitted-locale`

If you don't want your main locale to have a slug, you can set it as the `omitted-locale` (not the custom slug).
If you do this, no additional detectors will run after the `UrlDetector` and `OmittedLocaleDetector`.
This makes sense, because the locale will always be determined by those two in this scenario.

Example:

```php
'omitted-locale' => 'en',
```

Result:

- /example-route (English without slug)
- /nl/example-route (Other locales with slug)

Default: `null`

### ☑️ `trusted-detectors`

Add any detector class name to this array to make it trusted. (do not remove it from the `detectors` array)
When a trusted detector returns a locale, it will be used as the app locale, regardless if it's a supported locale or not.

Default: `[]`

### ☑️ `url-segment`

The index of the URL segment that has the locale, when using the `UrlDetector`.

Default: `1`

### ☑️ `route-action`

The custom route action that holds the locale, when using the `RouteActionDetector`.

Default: `locale`

To use the custom route action `locale`, you register a route like this:

```php
Route::group(['locale' => 'nl'], function () {
    //Route::get(...);
});
```

### ☑️ `user-attribute`

The attribute on the user model that holds the locale, when using the `UserDetector`.
If the user model does not have this attribute, this detector check will be skipped.

Default: `locale`

### ☑️ `session-key`

The session key that holds the locale, when using the `SessionDetector` and `SessionStore`.

Default: `locale`

### ☑️ `cookie-name`

The name of the cookie that holds the locale, when using the `CookieDetector` and `CookieStore`.

Default: `locale`

### ☑️ `cookie-minutes`

The lifetime of the cookie that holds the locale, when using the `CookieStore`.

Default: `60 * 24 * 365` (1 year)

## 🚧 Testing

```bash
composer test
```
## ☕️ Credits

- [Ivan Vermeyen](https://github.com/ivanvermeyen)
- [All contributors](https://github.com/codezero-be/laravel-localizer/contributors)

## 🔒 Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## 📑 Changelog

A complete list of all notable changes to this package can be found on the
[releases page](https://github.com/codezero-be/laravel-localizer/releases).

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
