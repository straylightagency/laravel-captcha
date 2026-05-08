<?php

namespace Straylightagency\LaravelCaptcha\Verifiers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Straylightagency\LaravelCaptcha\VerifierContract;

/**
 * Cloudflare Turnstile Verifier
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
readonly class TurnstileVerifier implements VerifierContract
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
        $response = Http::asJson()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $this->secret_key,
            'response' => $token,
            'remoteip' => $ip,
        ]);

        return boolval($response->json('success'));
    }

    /**
     * Return the Cloudflare Turnstile script used to generate the captcha token.
     *
     * @return string
     */
    public function script(): string
    {
        return '<script>window.turnstile_site_key = "' . $this->site_key . '";</script>
<link rel="preconnect" href="https://challenges.cloudflare.com" />
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>';
    }
}