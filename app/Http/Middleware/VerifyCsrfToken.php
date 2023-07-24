<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'api/verification/requests/store',
        // 'api/approved/verification/*'
        'api/announcement/store',
        'api/announcement/fetch/mobile',
        'users/control/access/search'
    ];
}
