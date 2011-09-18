<?php

namespace Insomnia\Kernel\Module\Session\Authentication;

use \Insomnia\Kernel\Module\Session\AuthenticationAbstract;

class Cookie extends AuthenticationAbstract
{
    public function __construct()
    {
        \ini_set( 'session.use_cookies',      1 );
        \ini_set( 'session.use_only_cookies', 1 );
    }
}