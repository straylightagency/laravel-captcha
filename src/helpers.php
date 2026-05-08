<?php

use Straylightagency\LaravelCaptcha\CaptchaRule;
use Straylightagency\LaravelCaptcha\Verifier;

if ( ! function_exists('captcha_script') ) {
    /**
     * Return the captcha verifier script to print in the layout
     *
     * @return string
     */
    function captcha_script(): string
    {
        return Verifier::script();
    }
}

if ( ! function_exists('captcha_rules') ) {
    /**
     * Return captcha rules : 'required', 'string' and CaptchaRule with injected Verifier
     *
     * @return array
     */
    function captcha_rules(): array
    {
        return CaptchaRule::rules();
    }
}