<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Dispatcher;

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

        \date_default_timezone_set( 'GMT' );

        Dispatcher::$controllerNamespace = 'Application\Controller\\';
        
        \ini_set( 'session.auto_start',       0 ); // Turn off sessions by default
        \ini_set( 'session.use_cookies',      0 ); // Turn off cookies by default
        \ini_set( 'session.use_only_cookies', 0 ); // Turn off cookies by default
        \ini_set( 'session.use_trans_sid',    0 ); // Turn off sid by default
    }

    public static function getLayoutPath()
    {
        return dirname( __DIR__ ) . '/View';
    }

    public static function getViewPath()
    {
        return dirname( __DIR__ ) . '/View';
    }
}