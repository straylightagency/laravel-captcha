<?php

namespace Straylightagency\LaravelCaptcha;

use Illuminate\Support\Arr;
use Straylightagency\LaravelCaptcha\Verifiers\FakeVerifier;
use Straylightagency\LaravelCaptcha\Verifiers\TurnstileVerifier;
use Straylightagency\LaravelCaptcha\Verifiers\ReCaptchaVerifier;
use Straylightagency\LaravelCaptcha\Verifiers\ReCaptchaEnterpriseVerifier;

/**
 * Verifier Factory class.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
class Verifier
{
    /**
     * Make the Verifier based on config.
     *
     * @return VerifierContract
     */
    public static function create(): VerifierContract {
        $config = config('captcha');
        $driver_config = Arr::get( $config, $driver = $config['driver'] );

        return match( $driver ) {
            'recaptcha' => self::createReCaptchaVerifier( $driver_config ),
            'recaptcha-enterprise' => self::createReCaptchaEnterpriseVerifier( $driver_config ),
            'turnstile' => self::createTurnstileVerifier( $driver_config ),
            default => self::createFakeVerifier(),
        };
    }

    /**
     * Create the Google ReCaptcha Verifier using site key and secret key.
     *
     * @param array $config
     * @return ReCaptchaVerifier
     */
    public static function createReCaptchaVerifier(array $config): ReCaptchaVerifier
    {
        return new ReCaptchaVerifier( $config['site_key'], $config['secret_key'] );
    }

    /**
     * Create the Google ReCaptcha Enterprise Verifier using site key, api key and project ID.
     *
     * @param array $config
     * @return ReCaptchaEnterpriseVerifier
     */
    public static function createReCaptchaEnterpriseVerifier(array $config): ReCaptchaEnterpriseVerifier
    {
        return new ReCaptchaEnterpriseVerifier( $config['site_key'], $config['api_key'], $config['project_id'] );
    }

    /**
     * Create the Cloudflare Turnstile Verifier.
     *
     * @param array $config
     * @return TurnstileVerifier
     */
    public static function createTurnstileVerifier(array $config): TurnstileVerifier
    {
        return new TurnstileVerifier( $config['site_key'], $config['secret_key'] );
    }

    /**
     * Create the Fake Verifier.
     *
     * @return FakeVerifier
     */
    public static function createFakeVerifier(): FakeVerifier
    {
        return new FakeVerifier();
    }

    /**
     * Return the selected Verifier's script.
     *
     * @return string
     */
    public static function script(): string
    {
        return app( VerifierContract::class )->script();
    }
}