<?php

namespace Straylightagency\LaravelCaptcha;

/**
 *
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
interface VerifierContract
{
    /**
     * Verify if the user recaptcha is valid or not.
     *
     * @param string|null $token
     * @param string|null $ip
     * @return bool
     */
    public function verify(string|null $token = null, string|null $ip = null): bool;

    /**
     * Some Verifier uses an embedded script to generate a token to send against their API.
     *
     * @return string
     */
    public function script(): string;
}