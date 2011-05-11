<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Application\Router\ApplicationRouter,
    \Application\Router\ErrorRouter;

require_once '../lib/Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader( 'Doctrine', dirname( __FILE__ ) . '/../lib' );
$classLoader->register();

$classLoader = new ClassLoader( 'Application', dirname( dirname( __FILE__ ) ) );
$classLoader->register();

// -----------------------------------------

define( 'APPLICATION_ENV', 'development' );

// -----------------------------------------

new \Application\Bootstrap\Insomnia;

try
{
    new ApplicationRouter;
}

catch( \Exception $e )
{
    $error = new ErrorRouter;
    $error->setException( $e );
}
