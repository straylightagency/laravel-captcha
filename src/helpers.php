<?php

use Straylightagency\LaravelCaptcha\Rules\Captcha;
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

if ( ! function_exists('captcha_rule') ) {
    /**
     * Return a new Captcha rule with injected Verifier.
     *
     * Use the `->default()` method if you want to use the `required` and `string` macro with the `captcha` rule.
     *
     * @return Captcha
     */
    function captcha_rule(): Captcha
    {
        return Captcha::make();
    }
}