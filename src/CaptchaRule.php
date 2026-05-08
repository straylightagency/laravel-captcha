<?php

namespace Straylightagency\LaravelCaptcha;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Validate a received token against a Verifier strategy.
 *
 * @package Straylightagency\LaravelCaptcha
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
readonly class CaptchaRule implements ValidationRule
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
     * Return the rules to use in the Validator.
     *
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'captcha' => [ 'required', 'string', new self( app( VerifierContract::class ) ) ],
        ];
    }
}
