<?php

namespace Straylightagency\LaravelCaptcha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Straylightagency\LaravelCaptcha\VerifierContract;
use Straylightagency\LaravelCaptcha\Verifiers\FakeVerifier;

/**
 * Validate a received token against a Verifier strategy.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
readonly class Captcha implements ValidationRule
{
    /**
     * @param VerifierContract $verifier
     */
    public function __construct(
        protected VerifierContract $verifier
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( ! $this->verifier->verify( $value, request()->ip() ) ) {
            $fail('captcha.verify')->translate();
        }
    }

    /**
     * Return the rules to use in the Validator array.
     * FakeVerifier do not use the `required` and `string` rules, avoiding error when no `captcha` field is sent.
     *
     * @return array[]
     */
    public function default(string $key_name = 'captcha'): array
    {
        if ( $this->verifier instanceof FakeVerifier ) {
            return [
                $key_name => [ $this ],
            ];
        }

        return [
            $key_name => [ 'required', 'string', $this ],
        ];
    }

    /**
     * Return a new instance of Captcha rule with the selected verifier.
     *
     * @return self
     */
    public static function make(): self
    {
        return new self( app( VerifierContract::class ) );
    }
}
