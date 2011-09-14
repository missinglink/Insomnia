<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader;

\define( 'ROOT', \dirname( \dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );
\define( 'APPLICATION_ENV', 'development' );

require_once \ROOT.'/lib/Doctrine/Common/ClassLoader.php';
\spl_autoload_register( array( new ClassLoader( 'Insomnia', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Doctrine', \ROOT . 'lib' ), 'loadClass' ) );
\spl_autoload_register( array( new ClassLoader( 'Application', \ROOT ), 'loadClass' ) );

$bootstrap = new \Application\Bootstrap\Insomnia;

Kernel::getInstance()
    ->addEndpoint( 'Application\Controller\TestController' )
    ->addEndpoint( 'Application\Controller\StatusController' )
    ->addEndpoint( 'Application\Controller\UserController' )
    ->addModule( new \Insomnia\Kernel\Module\ErrorHandler\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\HTTP\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Console\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Mime\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\RequestValidator\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\RestClient\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Documentation\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Compatability\Bootstrap )
    ->addModule( new \Insomnia\Kernel\Module\Cors\Bootstrap )
    ->run();