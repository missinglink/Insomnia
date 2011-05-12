<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;
use \Application\Bootstrap\Insomnia;
use \Application\Router\ApplicationRouter;
use \Application\Router\ErrorRouter;

require_once '../lib/Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader( 'Doctrine', dirname( __FILE__ ) . '/../lib' );
$classLoader->register();

$classLoader = new ClassLoader( 'Application', dirname( dirname( __FILE__ ) ) );
$classLoader->register();

// -----------------------------------------

define( 'APPLICATION_ENV', 'development' );

// -----------------------------------------

try
{
    new Insomnia;
    new ApplicationRouter;
}

catch( \Exception $e )
{
    new ErrorRouter( $e );
}