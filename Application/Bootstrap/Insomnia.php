<?php

namespace Application\Bootstrap;

use \Doctrine\Common\ClassLoader;
use \Insomnia\Request;
use \Insomnia\Dispatcher;
use \Insomnia\Registry;
use \Insomnia\Router;

class Insomnia
{
    public function __construct()
    {
        if( \APPLICATION_ENV === 'development' )
        {
            \error_reporting( \E_ALL | \E_STRICT );
            \ini_set( 'display_errors', 'On' );
        }

        \ini_set( 'session.auto_start',         0 ); // Turn off sessions by default
        \ini_set( 'session.use_cookies',        0 ); // Turn off cookies by default
        \ini_set( 'session.use_only_cookies',   0 ); // Turn off cookies by default
        \ini_set( 'session.use_trans_sid',      0 ); // Turn off sid by default

        Registry::set( 'request',               new Request );
        Registry::set( 'dispatcher',            new Dispatcher );
        Registry::set( 'router',                new Router );
        Registry::set( 'controller_namespace',  'Application\Controller\\' );
        Registry::set( 'action_suffix',         'Action' );
        Registry::set( 'view_path',             'Application/View' );
        Registry::set( 'layout_path',           'Application/View' );
        Registry::set( 'view_extension',        '.php' );
        Registry::set( 'default_content_type',  'application/json' );
        Registry::set( 'jsonp_callback_param',  '_jsonp' );
    }
}