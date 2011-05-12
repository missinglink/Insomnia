<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;
use \Application\Bootstrap\Insomnia;
use \Application\Router\ApplicationRouter;
use \Application\Router\ErrorRouter;

\define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
\spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );

\define( 'APPLICATION_ENV', 'development' );

try
{
    new Insomnia;
    new ApplicationRouter;
}

catch( \Exception $e )
{
    new ErrorRouter( $e );
}