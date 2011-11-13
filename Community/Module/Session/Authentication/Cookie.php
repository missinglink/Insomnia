<?php

namespace Community\Module\Session\Authentication;

use \Community\Module\Session\AuthenticationAbstract;

class Cookie extends AuthenticationAbstract
{
    public function __construct()
    {
        \ini_set( 'session.use_cookies',      1 );
        \ini_set( 'session.use_only_cookies', 1 );
    }
}