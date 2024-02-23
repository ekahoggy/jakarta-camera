<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $addHttpCookie = true;

    protected $except = [
        'site/*',
        'api/v1/public/checkEmail',
        'api/v1/public/register',
        'api/v1/public/login',
    ];
}
