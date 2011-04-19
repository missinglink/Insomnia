<?php

namespace Insomnia;

require_once 'Doctrine/Common/ClassLoader.php';
$classLoader = new \Doctrine\Common\ClassLoader( 'Insomnia' );
$classLoader->register();

$insomnia = new Application;

Application::$config['path']['web']         = realpath( __DIR__ ) . \DIRECTORY_SEPARATOR;
Application::$config['path']['lib']         = Application::$config['path']['web'] . 'Insomnia' . \DIRECTORY_SEPARATOR;
Application::$config['path']['controller']  = Application::$config['path']['lib'] . 'Controller' . \DIRECTORY_SEPARATOR;
Application::$config['path']['view']        = Application::$config['path']['lib'] . 'View' . \DIRECTORY_SEPARATOR;

//$insomnia->showErrors( true );
$insomnia->setRouter( new RestRouter );
$insomnia->run( new Request );