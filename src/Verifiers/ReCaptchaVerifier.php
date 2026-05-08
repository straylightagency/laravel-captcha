<?php

namespace Straylightagency\LaravelCaptcha\Verifiers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Straylightagency\LaravelCaptcha\VerifierContract;

/**
 * Google Recaptcha Verifier, using the old API with secret key.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
readonly class ReCaptchaVerifier implements VerifierContract
{
    /**
     * @param string $site_key
     * @param string $secret_key
     */
    public function __construct(
        protected string $site_key,
        protected string $secret_key,
    ) {
    }

    /**
     * Check if the user recaptcha is valid.
     *
     * @param string|null $token
     * @param string|null $ip
     * @return bool
     * @throws ConnectionException
     */
    public function verify(string|null $token = null, string|null $ip = null): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $this->secret_key,
            'response' => $token,
        ] );

        return boolval( $response->json('success') );
    }

    /**
     * Return the Google Recaptcha script used to generate the captcha token.
     *
     * @return string
     */
    public function script(): string
    {
        return '<script>window.recaptcha_site_key = "' . $this->site_key . '";</script>
<link rel="preconnect" href="https://www.google.com" />
<script src="https://www.google.com/recaptcha/api.js?render=' . $this->site_key . '"></script>';
    }
}