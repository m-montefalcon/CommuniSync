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
        /** 
         * AUTH WEB AND MOBILE
        */
        
        'api/register/store',
        'api/register/store/mobile',
        'api/login/store',
        'api/login/store/mobile',
        'api/logout/mobile',
        'api/update/profile/mobile/*',
        // 'api/verification/requests/store',
        // 'api/approved/verification/*'
        
        'api/update/*',
        'api/update/mobile',
        'api/verification/requests/store',
        'api/verification/requests/exist/*',
        'api/approved/verification/*',
        'api/announcement/store',
        'api/announcement/fetch/mobile/*',
        'api/users/control/access/search/mobile',
        'api/users/control/access/request/mobile',
        'api/users/control/access/accept/mobile',
        'api/users/control/access/decline/mobile',
        'api/users/control/access/get/all/validated/request/visitor/*',
        'api/admin/control/access/validated/*',
        'api/users/control/access/recorded/check/mobile',
        'api/users/control/access/recorded',
        'api/update/mobile/*',
        'api/get/profile/mobile/*',
        'api/users/blocklists/request/mobile',
        'api/admin/blocklists/validated/mobile/*',
        'api/users/control/access/fetch/all/request/mobile/*',
        'api/users/control/access/fetch/specific/request/mobile/*',
        'api/admin/payment/records/store',
        'api/admin/payment/records/get/all',
        'api/admin/payment/records/get/*',
        'api/user/payment/records/status/*',
        'api/user/payment/save/records/*',
        'api/admin/complaint/get/all/complaint/by/*',
        'api/user/complaint/store/mobile',
        'api/admin/complaint/fetch',
        'api/admin/complaint/update/*',
        'api/admin/complaint/close/*',
        'api/mvo/post/homeowner',
        'api/user/logbook/check/out',
        'api/user/logbook/out/*',
        'api/mvo/get/homeowner'
        
    ];
}
