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
    ->addEndpoint( 'Application\Controller\TestController' )
    ->addEndpoint( 'Application\Controller\UserController' )
    ->addEndpoint( 'Application\Controller\HtmlEntitiesController' )
    
    // Core modules - Removing these may make your system unstable
    ->addModule( new \Insomnia\Kernel\Module\ErrorHandler\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\HTTP\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Mime\Bootstrap )
        
    // Extra modules
    ->addModule( new \Insomnia\Kernel\Module\Console\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\RequestValidator\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\RestClient\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Compatability\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Cors\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Session\Bootstrap )
    
    // Community modules
    ->addModule( new \Community\Module\Welcome\Bootstrap )
    ->addModule( new \Community\Module\Documentation\Bootstrap )
    ->run();