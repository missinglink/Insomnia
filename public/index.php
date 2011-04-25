<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\RestRouter,
    \Insomnia\Router\ErrorRouter;

require_once '../lib/Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader( 'Doctrine', dirname( __FILE__ ) . '/../lib' );
$classLoader->register();

$classLoader = new ClassLoader( 'Application', dirname( dirname( __FILE__ ) ) );
$classLoader->register();

// -----------------------------------------

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

define('APPLICATION_ENV', "development");

// -----------------------------------------

new \Application\Bootstrap\Insomnia;
new \Application\Bootstrap\Doctrine;

try {
    $insomnia = new RestRouter( new Request );
    $insomnia->run();
}

catch( \Exception $e )
{
    $error = new ErrorRouter( new Request );
    $error->setException( $e );
}