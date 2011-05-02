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

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

define( 'APPLICATION_ENV', 'production' );

// -----------------------------------------

new \Application\Bootstrap\Insomnia;

try {
    $insomnia = new ApplicationRouter( new Request );
    $insomnia->run();
}

catch( \Exception $e )
{
    $error = new ErrorRouter( new Request );
    $error->setException( $e );
}