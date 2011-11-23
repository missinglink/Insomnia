<?php

namespace Application\Bootstrap;

use \Insomnia\Session as SessionManager,
    \Insomnia\Session\Storage\Disk as SessionStorage,
    \Insomnia\Session\Authentication\Cookie as SessionAuthentication;

class Session
{
    public static $sm;

    public function __construct()
    {
        self::$sm = new SessionManager;
        self::$sm->setName( 'EXAMPLE' );
        self::$sm->setStorage( new SessionStorage );
        self::$sm->setAuthentication( new SessionAuthentication );
        self::$sm->start();
    }
}