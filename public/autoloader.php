<?php

namespace Insomnia;

define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
define( 'APPLICATION_ENV', 'development' );

/**
 * SpeedLoader
 * 
 * An autoloader optimised for speed.
 * 
 * It usually out performs the Doctrine ClassLoader by a very small margin.
 * Use this if you are really worried about cutting every last millisecond.
 */
//require_once \ROOT . '/lib/Insomnia/SpeedLoader.php';
//
//$loader = new SpeedLoader;
//$loader->addNamespace( 'Insomnia', \ROOT . 'lib' )
//       ->addNamespace( 'Doctrine', \ROOT . 'lib' )
//       ->addNamespace( 'DoctrineExtensions', \ROOT . 'lib' )
//       ->addNamespace( 'Application', \ROOT )
//       ->addNamespace( 'Community', \ROOT )
//       ->register();


/**
 * Doctrine Autoloader
 * 
 * An excellent general purpose autoloader.
 * 
 * @link http://www.doctrine-project.org/api/common/2.0/doctrine/common/classloader.html
 */
use \Doctrine\Common\ClassLoader;
require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'DoctrineExtensions', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Community', \ROOT ), 'loadClass' ) );