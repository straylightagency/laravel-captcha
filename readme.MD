# Laravel Captcha

Adds Captcha verification functionality to Laravel based on services API.

## Installation

Require this package with composer.
```shell
composer require straylightagency/laravel-captcha
```

### Laravel without auto-discovery:

If you do not use auto-discovery, add the `CaptchaServiceProvider` to the providers array in `bootstrap/providers.php` :
```php
\Straylightagency\LaravelCaptcha\CaptchaServiceProvider::class,
```

Use this artisan command to publish the captcha.php file inside your config folder :
```shell
php artisan vendor:publish --tag=captcha
```

You must set the site key and secret key based on the service you want to use inside your `.env` file :
```dotenv
## select your drive here : fake, recaptcha, recaptcha-enterprise or turnstile
CAPTCHA_DRIVER=recaptcha-enterprise

## if you use Google ReCaptcha or ReCaptcha Enterprise :
GOOGLE_RECAPTCHA_SITE_KEY="FAK3S1T3K3Y21AI3C9S3VJZ-V65M1SMWLGEPX4SB"
GOOGLE_RECAPTCHA_API_KEY="FAK3AP1K3YXEFG7V2EV1HK1-RGGGU817475938X1O0"
GOOGLE_RECAPTCHA_PROJECT_ID="project-123456"
GOOGLE_RECAPTCHA_SECRET_KEY="FAK3S3CR3TK3YBQYVMJQYMLT4W57RTFFO0MF38VB"

## if you use Cloudflare Turnstile :
CLOUDFLARE_TURNSTILE_SITE_KEY="FAK3S1T3K3YNPY1AEHI2O6P-6AYWQVLJ8439LG3N"
CLOUDFLARE_TURNSTILE_SECRET_KEY="FAK3S3CR3TK3Y8X1O0T0Q2KBQWLKEDUQYNP6GHE3"
```

In your languages directory, add an extra translation in every `validation.php` language file :
```php
'captcha' => 'The captcha is not valid.',
```

## Validation

You can use the `captcha_rule()` helper function directly inside the validation array :
```php
$validator = Validator::make( $request->all(), [
    // [...]
    'captcha' => ['required', 'string', captcha_rule()],
] );
```

You can also use the `captcha` rule macro :
```php
$validator = Validator::make( $request->all(), [
    // [...]
    'captcha' => ['required|string|captcha'], // works too
] );
```

Use the `->default()` method if you want to use the `required` and `string` macro with the `captcha` rule.
```php
$validator = Validator::make( $request->all(), [
    'name' => ['required', 'string'],
    'email' => ['required', 'string', 'email'],
    'content' => ['required', 'string'],
    ...captcha_rule()->default(), 
    // parameter $key_name of default() method allow you to edit the field name.
] );
```

Some Verifier needs a script tag inside the `<head>` tag of your HTML page, you can use an helper function to print 
the right script based on the selected Verifier : 
```bladehtml
<head>
    <!-- rest of your head tag -->
    {!! captcha_script() !!}
    <!-- rest of your head tag -->
</head>
```

For more information about frontend integration, check the documentation bellow from the API service you want to use.

## Requirement

PHP 8.3 or above

## See also

- [Google ReCaptcha](https://developers.google.com/recaptcha/intro)
- [Google ReCaptcha Enterprise](https://docs.cloud.google.com/recaptcha/docs)
- [Cloudflare Turnstile](https://developers.cloudflare.com/turnstile/)

## Credits

- [Anthony Pauwels](https://github.com/anthonypauwels)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). 