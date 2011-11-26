<?php

namespace Insomnia;

define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
define( 'APPLICATION_ENV', 'production' );

/**
 *  Opl Autoloader
 * 
 * @link http://static.invenzzia.org/docs/opl/3_0/book/en/autoloader.available.generic-loader.html
 */
use \Opl\Autoloader\GenericLoader;
require_once \ROOT.'/lib/Opl3/src/Opl/Autoloader/GenericLoader.php';
$loader = new GenericLoader( \ROOT );
$loader->addNamespace( 'Opl', \ROOT . 'lib/Opl3/src' );
$loader->addNamespace( 'Insomnia', \ROOT . 'lib' );
$loader->addNamespace( 'Doctrine', \ROOT . 'lib' );
$loader->addNamespace( 'DoctrineExtensions', \ROOT . 'lib' );
$loader->addNamespace( 'Application', \ROOT );
$loader->addNamespace( 'Community', \ROOT );
$loader->register();

/**
 *  Doctrine Autoloader
 * 
 * @link http://www.doctrine-project.org/api/common/2.0/doctrine/common/classloader.html
 */
//use \Doctrine\Common\ClassLoader;
//require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
//spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
//spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
//spl_autoload_register( array( new ClassLoader( 'DoctrineExtensions', \ROOT . 'lib' ), 'loadClass' ) );
//spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );
//spl_autoload_register( array( new ClassLoader( 'Community', \ROOT ), 'loadClass' ) );