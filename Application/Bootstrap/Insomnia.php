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
        // Error Settings
        error_reporting( 0 );
        ini_set( 'display_errors',             0 ); // Don't output errors
        ini_set( 'html_errors',                0 ); // Disable HTML errors

        // Date, Time & Encoding Settings
        setlocale( \LC_ALL, 'en_GB' );
        ini_set( 'date.timezone',              'Europe/London' );
        ini_set( 'default_charset',            'utf-8' ); // Set encoding
        ini_set( 'mbstring.internal_encoding', 'utf-8' ); // Set encoding

        // Session Settings
        ini_set( 'session.auto_start',         0 ); // Turn off sessions by default
        ini_set( 'session.use_cookies',        0 ); // Turn off cookies by default
        ini_set( 'session.use_only_cookies',   0 ); // Turn off cookies by default
        ini_set( 'session.use_trans_sid',      0 ); // Turn off sid by default
        
        // Development Mode
        if( defined( 'APPLICATION_ENV' ) && \APPLICATION_ENV === 'development' )
        {
            error_reporting( \E_ALL | \E_STRICT );
            ini_set( 'display_errors', 1 );
        }
    }
}