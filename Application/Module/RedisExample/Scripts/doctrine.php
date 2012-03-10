<?php

use \Doctrine\Common\ClassLoader;

\define( 'ROOT', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . \DIRECTORY_SEPARATOR );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Symfony',  \ROOT . 'lib' ), 'loadClass' )  );

// -----------------------------------------

define('APPLICATION_ENV', "development");

// -----------------------------------------

$doctrine = new \Application\Module\RedisExample\Bootstrap\Doctrine;
$doctrine->console();