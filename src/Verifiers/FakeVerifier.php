<?php

namespace Straylightagency\LaravelCaptcha\Verifiers;

use Straylightagency\LaravelCaptcha\VerifierContract;

/**
 * Fake Verifier, useful for local environment, avoiding useless verifications.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
class FakeVerifier implements VerifierContract
{
    /**
     * Always return true.
     *
     * @param string|null $token
     * @param string|null $ip
     * @return bool
     */
    public function verify(string|null $token = null, string|null $ip = null): bool
    {
        return true;
    }

    /**
     * There is no script to load.
     *
     * @return string
     */
    public function script(): string
    {
        return '';
    }
}