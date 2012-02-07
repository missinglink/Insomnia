<?php

namespace Insomnia;

require_once 'autoloader.php';

// Run Bootstraps
new \Application\Bootstrap\Insomnia;

Kernel::getInstance()
    
    // Core modules - Warning: Removing these may make your system unstable or unusable
    ->addModule( new \Community\Module\ErrorHandler\Bootstrap )
    ->addModule( new \Community\Module\HTTP\Bootstrap )
    ->addModule( new \Community\Module\Mime\Bootstrap )
        
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