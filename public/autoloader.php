<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;

define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
define( 'APPLICATION_ENV', 'development' );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );
spl_autoload_register( array( new ClassLoader( 'Community', \ROOT ), 'loadClass' ) );