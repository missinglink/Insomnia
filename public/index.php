<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;

define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
define( 'APPLICATION_ENV', 'development' );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Community', \ROOT ), 'loadClass' ) );

$bootstrap = new \Application\Bootstrap\Insomnia;

Kernel::getInstance()
    
    // Core modules
    // Warning: Removing these may make your system unstable or unusable
    ->addModule( new \Insomnia\Kernel\Module\ErrorHandler\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\HTTP\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Mime\Bootstrap )
        
    // Extra modules
    ->addModule( new \Community\Module\Console\Bootstrap )
    ->addModule( new \Community\Module\RequestValidator\Bootstrap )
    ->addModule( new \Community\Module\RestClient\Bootstrap )
    ->addModule( new \Community\Module\Compatability\Bootstrap )
    ->addModule( new \Community\Module\Cors\Bootstrap )
    ->addModule( new \Community\Module\Session\Bootstrap )
    
    // Community modules
    ->addModule( new \Community\Module\Welcome\Bootstrap )
    ->addModule( new \Community\Module\Documentation\Bootstrap )
        
    // User modules
    ->addEndpoint( 'Application\Controller\TestController' )
    ->addEndpoint( 'Application\Controller\UserController' )
    ->addEndpoint( 'Application\Controller\HtmlEntitiesController' )
        
    // Run application
    ->run();