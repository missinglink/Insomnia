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
        if( \APPLICATION_ENV === 'development' )
        {
            \error_reporting( \E_ALL | \E_STRICT );
            \ini_set( 'display_errors', 'On' );
        }

        \date_default_timezone_set( 'GMT' );
        \ini_set( 'session.auto_start',         0 ); // Turn off sessions by default
        \ini_set( 'session.use_cookies',        0 ); // Turn off cookies by default
        \ini_set( 'session.use_only_cookies',   0 ); // Turn off cookies by default
        \ini_set( 'session.use_trans_sid',      0 ); // Turn off sid by default

        $classLoader = new ClassLoader( 'Insomnia', '../lib' );
        $classLoader->register();

        $classLoader = new ClassLoader( 'DoctrineExtensions', '../lib' );
        $classLoader->register();

        $classLoader = new ClassLoader( 'Symfony', '../lib' );
        $classLoader->register();

        Registry::set( 'request',               new Request );
        Registry::set( 'dispatcher',            new Dispatcher );
        Registry::set( 'controller_namespace',  'Application\Controller\\' );
        Registry::set( 'action_suffix',         'Action' );
        Registry::set( 'view_path',             \realpath( dirname( __DIR__ ) . \DIRECTORY_SEPARATOR . 'View' ) . \DIRECTORY_SEPARATOR );
        Registry::set( 'layout_path',           \realpath( dirname( __DIR__ ) . \DIRECTORY_SEPARATOR . 'View' ) . \DIRECTORY_SEPARATOR );
        Registry::set( 'view_extension',        '.php' );
    }
}