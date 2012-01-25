<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function catchException( \Exception $e )
    {
        // Do not halt script execution for all recoverable errors in production
        if( \APPLICATION_ENV !== 'development' && $e instanceof \ErrorException && $e->getCode() > \E_ERROR )
        {
            return true;
        }

        \BNT\Utils\Logger::log( $e->getMessage(), \Zend_Log::WARN, $e );
        
        try
        {
            $endPoint = new EndPoint( 'Insomnia\Kernel\Module\ErrorHandler\Controller\ErrorAction', 'action' );
            $endPoint->dispatch( $e );
        }
        catch( \Exception $e2 )
        {
            header( 'Content-type: text/plain' );
            echo 'Service is currently unavailable, Please try again later.' . PHP_EOL;
            if( \APPLICATION_ENV === 'development' )
                {
                echo $e2->getMessage() . PHP_EOL;
                echo $e2->getFile() . ':' . $e2->getLine() . PHP_EOL;
                echo $e2->getTraceAsString() . PHP_EOL;
                if( ( $p = $e2->getPrevious() ) instanceof \Exception )
                {
                    echo PHP_EOL;
                    echo "\t" . $p->getMessage() . PHP_EOL;
                    echo "\t" . $p->getFile() . ':' . $p->getLine() . PHP_EOL;
                    echo "\t" . $p->getTraceAsString() . PHP_EOL;
                }
            }
            exit;
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    public function error( $errno, $errstr, $errfile, $errline )
    {
        if( isset( $errstr, $errno, $errfile, $errline ) )
        {
            $exception = new \ErrorException( $errstr, $errno, 1, $errfile, $errline );
            return $this->catchException( $exception );
        }
        
        else
        {
            \BNT\Utils\Logger::log( 'Error Handler failed to get the required info from last error.', \Zend_Log::CRIT );
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    public function registerExceptionHandler()
    {
        set_exception_handler( array( $this, 'catchException' ) );
    }
    
    public function registerErrorHandler()
    {
        set_error_handler( array( $this, 'error' ), E_ALL | E_STRICT );
        //register_shutdown_function( array( $this, 'error' ) );
    }
}