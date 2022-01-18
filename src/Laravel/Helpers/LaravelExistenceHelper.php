<?php

namespace Sammyjo20\Saloon\Laravel\Helpers;

class LaravelExistenceHelper
{
    /**
     * Check if it can detect Laravel
     *
     * @return bool
     */
    public static function check(): bool
    {
        return function_exists('app') && method_exists(app(), 'version') && is_string(app()->version()) && (int)app()->version() >= 8;
    }
}
