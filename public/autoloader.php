<?php

namespace Insomnia;

define( 'ROOT', dirname( dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
define( 'APPLICATION_ENV', 'development' );

/**
 * Symfony Autoloader
 * 
 * An excellent general purpose autoloader.
 */
use \Symfony\Component\ClassLoader\UniversalClassLoader;
require_once \ROOT.'/lib/ClassLoader/UniversalClassLoader.php';

$classLoader = new UniversalClassLoader;
$classLoader->registerNamespace( 'Insomnia', \ROOT . 'lib' );
$classLoader->registerNamespace( 'Doctrine\\Common', \ROOT . 'lib/doctrine-common/lib' );
$classLoader->registerNamespace( 'Application', \ROOT );
$classLoader->registerNamespace( 'Community', \ROOT );
$classLoader->register();