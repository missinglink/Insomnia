<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;
use \Application\Bootstrap\Insomnia;

use \Insomnia\Controller\Action;
use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Annotation\Parser\Validation as ValidationParser;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Registry;
use \Insomnia\Dispatcher\EndPoint;


\define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
\spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );

\define( 'APPLICATION_ENV', 'development' );

function my_exception_handler( \Exception $e )
{
    Registry::set( 'request', new \Insomnia\Request );
    Registry::get( 'request' )->setParam( 'exception', $e );
    
    $endpoint = new EndPoint( Registry::get( 'error_endpoint' ), 'action' );
    $endpoint->dispatch();
}
\set_exception_handler( 'my_exception_handler' );

require_once 'os_error_handler.php';
\set_error_handler( 'os_error_handler' );

try
{
    $application = new Insomnia;
    
    $kernel = new \Insomnia\Kernel;
    
    $x = new \Insomnia\Component\Documentation\DocumentationComponent;
    $x->bootstrap( $kernel );
    
    $application->getRouter()->dispatch();
}

catch( \Exception $e )
{
    my_exception_handler( $e );
}