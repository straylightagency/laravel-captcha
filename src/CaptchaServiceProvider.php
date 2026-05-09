<?php
namespace Straylightagency\LaravelCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rule;
use Straylightagency\LaravelCaptcha\Rules\Captcha;

/**
 *
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind( VerifierContract::class, fn () => Verifier::create() );

        $this->callAfterResolving('validator', function (Factory $validator) {
            $validator->extendDependent('captcha', function ($attribute, $value, array $parameters, $validator) {
                return InvokableValidationRule::make( Captcha::make() )
                    ->setValidator( $validator )
                    ->passes( $attribute, $value );
            } );
        } );

        Rule::macro('captcha', fn () => Captcha::make() );
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes( [
            __DIR__.'/config/captcha.php' => config_path('captcha.php'),
        ], 'captcha' );
    }
}
