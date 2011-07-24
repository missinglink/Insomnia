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


\define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
\spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );

\define( 'APPLICATION_ENV', 'development' );

try
{
    new Insomnia;

    $router = Registry::get( 'router' );
    $router->addClass( 'Application\Controller\ClientController' );
    $router->addClass( 'Application\Controller\TestController' );
    $router->addClass( 'Application\Controller\StatusController' );
    $router->addClass( 'Application\Controller\DocumentationController' );   
    $router->dispatch();
    
    throw new \Insomnia\Router\RouterException( 'Failed to Match any Routes' );
}

catch( \Exception $e )
{   
    \Insomnia\Registry::get( 'request' )->setParam( 'exception', $e );
    Registry::get( 'dispatcher' )->dispatch( '\Application\Controller\Errors\ErrorAction', 'action' );
}
