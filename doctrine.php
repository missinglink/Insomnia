<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;

require_once 'lib/Doctrine/Common/ClassLoader.php';
$classLoader = new ClassLoader( 'Doctrine', dirname( __FILE__ ) . '/lib' );
$classLoader->register();

$classLoader = new ClassLoader( 'Application', dirname( __FILE__ ) );
$classLoader->register();

// -----------------------------------------

$classLoader = new \Doctrine\Common\ClassLoader( 'Symfony', dirname( __FILE__ ) . '/lib' );
$classLoader->register();

// -----------------------------------------

define('APPLICATION_ENV', "development");

// -----------------------------------------

$doctrine = new \Application\Bootstrap\Doctrine;
$doctrine->console();