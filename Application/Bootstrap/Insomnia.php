<?php

namespace Application\Bootstrap;

use \Insomnia\Kernel;

class Insomnia
{
    public function __construct()
    {
        if( \APPLICATION_ENV === 'development' )
        {
            error_reporting( \E_ALL | \E_STRICT );
            ini_set( 'display_errors', 'On' );
        }
        
        ini_set( 'html_errors',                0 ); // Disable HTML errors
        
        ini_set( 'session.auto_start',         0 ); // Turn off sessions by default
        ini_set( 'session.use_cookies',        0 ); // Turn off cookies by default
        ini_set( 'session.use_only_cookies',   0 ); // Turn off cookies by default
        ini_set( 'session.use_trans_sid',      0 ); // Turn off sid by default
        
        ini_set( 'default_charset',            'utf-8' ); // Set encoding
        ini_set( 'mbstring.internal_encoding', 'utf-8' ); // Set encoding
        
        // Set insomnia annotation namespace
        Kernel::addAnnotationAlias( 'insomnia', 'Insomnia\Annotation\\' );
        
        // Core modules - Warning: Removing these may make your system unstable or unusable
        Kernel::addModule( new \Community\Module\ErrorHandler\Bootstrap );
        Kernel::addModule( new \Community\Module\HTTP\Bootstrap );
        Kernel::addModule( new \Community\Module\Mime\Bootstrap );

        // Community modules
        Kernel::addModule( new \Community\Module\Console\Bootstrap );
        Kernel::addModule( new \Community\Module\RequestValidator\Bootstrap );
        Kernel::addModule( new \Community\Module\RestClient\Bootstrap );
        Kernel::addModule( new \Community\Module\Compatibility\Bootstrap );
        Kernel::addModule( new \Community\Module\Cors\Bootstrap );
        Kernel::addModule( new \Community\Module\Session\Bootstrap );
        Kernel::addModule( new \Community\Module\Documentation\Bootstrap );
      
        // User modules
        Kernel::addModule( new \Application\Module\CrudExample\Bootstrap );
        Kernel::addModule( new \Application\Module\HtmlEntities\Bootstrap );
        Kernel::addModule( new \Application\Module\Welcome\Bootstrap );
    }
}