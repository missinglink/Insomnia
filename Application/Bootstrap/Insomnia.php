<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader;
use \Insomnia\Request;
use \Insomnia\Dispatcher;
use \Insomnia\Registry;

class Insomnia
{
    public function __construct()
    {
        if( \APPLICATION_ENV === 'development' )
        {
            error_reporting( \E_ALL | \E_STRICT );
            ini_set( 'display_errors', 'On' );
        }

        else if( function_exists( 'xdebug_disable' ) )
        {
            xdebug_disable();
        }
        
        ini_set( 'session.auto_start',         0 ); // Turn off sessions by default
        ini_set( 'session.use_cookies',        0 ); // Turn off cookies by default
        ini_set( 'session.use_only_cookies',   0 ); // Turn off cookies by default
        ini_set( 'session.use_trans_sid',      0 ); // Turn off sid by default
        
        ini_set( 'default_charset',            'utf-8' ); // Set encoding
        ini_set( 'mbstring.internal_encoding', 'utf-8' ); // Set encoding
    }
}