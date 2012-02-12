<?php

namespace Insomnia;

require_once 'autoloader.php';
//echo 'a';
// Run Bootstraps
new \Application\Bootstrap\Insomnia;

foreach( array(
    new \Community\Module\HTTP\Bootstrap,
    new \Community\Module\Mime\Bootstrap )
        as $module )
{
    $module->run( Kernel::getInstance() );
}

$errorHandler = new \Insomnia\Kernel\Module\ErrorHandler\Bootstrap;
$errorHandler->run( \Insomnia\Kernel::getInstance() );
$errorHandler->getErrorHandler()->useBuffer();

//throw new \Exception( 'hello' );


Kernel::getInstance()
    
    // Core modules - Warning: Removing these may make your system unstable or unusable
        
    // Community modules
    ->addModule( new \Community\Module\Console\Bootstrap )
    ->addModule( new \Community\Module\RequestValidator\Bootstrap )
    ->addModule( new \Community\Module\RestClient\Bootstrap )
    ->addModule( new \Community\Module\Compatibility\Bootstrap )
    ->addModule( new \Community\Module\Cors\Bootstrap )
    ->addModule( new \Community\Module\Session\Bootstrap )
    ->addModule( new \Community\Module\Documentation\Bootstrap )
        
    // User modules
    ->addModule( new \Application\Module\Examples\Bootstrap )
    ->addModule( new \Application\Module\CrudExample\Bootstrap )
    ->addModule( new \Application\Module\HtmlEntities\Bootstrap )
    ->addModule( new \Application\Module\Welcome\Bootstrap )
        
    // Run application
    ->run();