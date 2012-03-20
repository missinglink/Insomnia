<?php

namespace Community\Module\ErrorHandler;

use \Insomnia\Kernel;
use \Insomnia\Kernel\Module\ErrorHandler\Bootstrap as KernelModule;

/**
 * Insomnia error module
 * 
 * Catches exceptions and provides debugging information
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    // This class skeleton is provided so that you can override the
    // default behaviour of the Insomnia ErrorHandler module.
    
    public function run( Kernel $kernel )
    {
        $hiccup = new Hiccup;
        
        $this->setExceptionHandler( $hiccup );
        $this->setErrorHandler( $hiccup );
        
        $this->getExceptionHandler()->registerExceptionHandler();
        $this->getErrorHandler()->registerErrorHandler();
    }
}