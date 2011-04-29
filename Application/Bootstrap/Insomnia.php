<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader;

class Insomnia
{
    public function __construct()
    {
        $classLoader = new ClassLoader( 'Insomnia', '../lib' );
        $classLoader->register();

        
        ini_set( 'session.auto_start',       0 ); // Turn off sessions by default
        ini_set( 'session.use_cookies',      0 ); // Turn off cookies by default
        ini_set( 'session.use_only_cookies', 0 ); // Turn off cookies by default
        ini_set( 'session.use_trans_sid',    0 ); // Turn off sid by default
    }
}