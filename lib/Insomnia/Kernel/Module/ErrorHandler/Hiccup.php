<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function catchException( \Exception $e )
    {
        try
        {
            $endPoint = new EndPoint( '\Application\Controller\Errors\ErrorAction', 'action' );
            $endPoint->dispatch( $e );
        }
        catch( \Exception $e )
        {
            header( 'Content-type: text/plain' );
            echo 'Service is currently unavailable, Please try again later.';
            die;
        } 
    }
    
    public function error( $errno, $errstr, $errfile, $errline )
    {
        throw new \ErrorException( $errstr, 0, $errno, $errfile, $errline );
    }
    
    public function registerExceptionHandler()
    {
        set_exception_handler( array( $this, 'catchException' ) );
    }
    
    public function registerErrorHandler()
    {
        set_error_handler( array( $this, 'error' ) );
    }
}