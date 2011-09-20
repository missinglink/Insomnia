<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function catchException( \Exception $e )
    {
        try
        {
            $endPoint = new EndPoint( '\Insomnia\Kernel\Module\ErrorHandler\Controller\ErrorAction', 'action' );
            $endPoint->dispatch( $e );
        }
        catch( \Exception $e2 )
        {
            header( 'Content-type: text/plain' );
            echo 'Service is currently unavailable, Please try again later.' . PHP_EOL;
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
            die;
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    public function error()
    {
        $error = error_get_last();
        
        if( $error !== NULL )
        {
            //ob_end_clean();
            
            $exception = new \ErrorException( $error[ 'message' ], 0, $error[ 'type' ], $error[ 'file' ], $error[ 'line' ] );
            return $this->catchException( $exception );
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