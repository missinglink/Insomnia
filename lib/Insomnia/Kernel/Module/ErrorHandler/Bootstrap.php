<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Pattern\KernelModule;
use \Insomnia\Kernel;

/**
 * Insomnia error module
 * 
 * Catches exceptions and provides debugging information
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    private $exceptionHandler;
    private $errorHandler;
    
    /**
     * Module configuration
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        $hiccup = new Hiccup;
        
        $this->setExceptionHandler( $hiccup );
        $this->setErrorHandler( $hiccup );
        
        $this->getExceptionHandler()->registerExceptionHandler();
        $this->getErrorHandler()->registerErrorHandler();
    }
    
    public function getExceptionHandler()
    {
        return $this->exceptionHandler;
    }

    public function setExceptionHandler( $exceptionHandler )
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    public function getErrorHandler()
    {
        return $this->errorHandler;
    }

    public function setErrorHandler( $errorHandler )
    {
        $this->errorHandler = $errorHandler;
    }
}