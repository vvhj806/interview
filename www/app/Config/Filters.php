<?php

namespace Config;

use App\Filters\{
    AdminLoginFilter,
    AdminMainFilter,
    AdminOnlyFilter,
    ThrottleFilter,
    ThrottleErrorFilter,
    WwwLoginFilter,
    WwwNotLoginFilter,
    WwwUserFilter,
    WwwTempUserFilter,
    WwwBizFilter,
    ResourceFilter,
};

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'auth'          => LoginFilter::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'admin-login' => AdminLoginFilter::class,
        'admin-main' => AdminMainFilter::class,
        'admin-only' => AdminOnlyFilter::class,
        'throttle' => ThrottleFilter::class,
        'throttle-error' => ThrottleErrorFilter::class,
        'www-login' => WwwLoginFilter::class,
        'www-not-login' => WwwNotLoginFilter::class,
        'www-user' => WwwUserFilter::class,
        'www-temp-user' => WwwTempUserFilter::class,
        'resource' => ResourceFilter::class    // add a new filter alias
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf'=> ['except'=>'app/get_token.php'],
            //'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = ['post' => ['throttle', 'throttle-error']]; // todo 보안

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'resource' => [
            'before' => [
                'rest/users',   // add the resource endpoint path that need to be validated
            ],
        ],
    ];
}
