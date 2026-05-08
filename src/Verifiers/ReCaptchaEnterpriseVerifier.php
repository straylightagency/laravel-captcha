<?php

namespace Straylightagency\LaravelCaptcha\Verifiers;

use Straylightagency\LaravelCaptcha\VerifierContract;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Google Recaptcha Enterprise Verifier, using the new API with site key, api key and project ID, no longer using secret key.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
readonly class ReCaptchaEnterpriseVerifier implements VerifierContract
{
    /**
     * @param string $site_key
     * @param string $api_key
     * @param string $project_id
     */
    public function __construct(
        protected string $site_key,
        protected string $api_key,
        protected string $project_id,
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
        $response = Http::asJson()->post('https://recaptchaenterprise.googleapis.com/v1/projects/' . $this->project_id . '/assessments?key=' . $this->api_key, [
            'event' => [
                'siteKey' => $this->site_key,
                'token' => $token,
            ]
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
<script src="https://www.google.com/recaptcha/enterprise.js?render=' . $this->site_key . '"></script>';
    }
}