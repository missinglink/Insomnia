<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;
use \Application\Bootstrap\Insomnia;

require_once '../lib/Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader( 'Doctrine', dirname( __FILE__ ) . '/../lib' );
$classLoader->register();

$classLoader = new ClassLoader( 'Application', dirname( dirname( __FILE__ ) ) );
$classLoader->register();

new Insomnia;