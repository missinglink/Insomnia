<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Request,
    \Insomnia\Dispatcher,
    \Insomnia\Registry;

class Insomnia
{
    public function __construct()
    {
        $classLoader = new ClassLoader( 'Insomnia', '../lib' );
        $classLoader->register();

        $classLoader = new ClassLoader( 'DoctrineExtensions', '../lib' );
        $classLoader->register();

        $classLoader = new ClassLoader( 'Symfony', '../lib' );
        $classLoader->register();

        \error_reporting( \APPLICATION_ENV === 'development' ? \E_ALL | \E_STRICT : 0 );
        \ini_set( 'display_errors', \APPLICATION_ENV === 'development' ? 'On' : 'Off' );

        \date_default_timezone_set( 'GMT' );

        \ini_set( 'session.auto_start',       0 ); // Turn off sessions by default
        \ini_set( 'session.use_cookies',      0 ); // Turn off cookies by default
        \ini_set( 'session.use_only_cookies', 0 ); // Turn off cookies by default
        \ini_set( 'session.use_trans_sid',    0 ); // Turn off sid by default

        \Insomnia\Registry::set( 'request',                 new Request );
        \Insomnia\Registry::set( 'dispatcher',              new Dispatcher );
        \Insomnia\Registry::set( 'controller_namespace',    'Application\Controller\\' );
        \Insomnia\Registry::set( 'view_path',               realpath( dirname( __DIR__ ) . \DIRECTORY_SEPARATOR . 'View' ) . \DIRECTORY_SEPARATOR );
        \Insomnia\Registry::set( 'layout_path',             realpath( dirname( __DIR__ ) . \DIRECTORY_SEPARATOR . 'View' ) . \DIRECTORY_SEPARATOR );
    }
}