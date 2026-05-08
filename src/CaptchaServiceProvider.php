<?php
namespace Straylightagency\LaravelCaptcha;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes( [
            __DIR__.'/config/captcha.php' => config_path('captcha.php'),
        ] );
    }
}
