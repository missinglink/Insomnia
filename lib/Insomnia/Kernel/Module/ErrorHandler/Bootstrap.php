<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Pattern\KernelModule;
use \Insomnia\Kernel;

class Bootstrap extends KernelModule
{
    private $exceptionHandler;
    private $errorHandler;
    
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