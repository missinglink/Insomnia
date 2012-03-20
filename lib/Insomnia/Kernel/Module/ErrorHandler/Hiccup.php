<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function catchException( \Exception $e )
    {
        try
        {
            // Catchable Exception
            $this->log( $e->getMessage(), $e );

            $endPoint = new EndPoint( 'Insomnia\Kernel\Module\ErrorHandler\Controller\ErrorAction', 'action' );
            
            if( \APPLICATION_ENV === 'development' )
            {
                $this->addDebugInfoToResponseHeaders( $endPoint->getController()->getResponse(), $e );
            }
            
            $endPoint->dispatch( $e );
        }
        
        catch( \Exception $e2 )
        {
            $lastWords = '';
            if( \APPLICATION_ENV === 'development' )
            {
                $lastWords .= $e2->getMessage() . \PHP_EOL;
                $lastWords .= $e2->getFile() . ':' . $e2->getLine() . \PHP_EOL;
                $lastWords .= $e2->getTraceAsString() . \PHP_EOL;
                
                if( ( $p = $e2->getPrevious() ) instanceof \Exception )
                {
                    $lastWords .= \PHP_EOL;
                    $lastWords .= "\t" . $p->getMessage() . \PHP_EOL;
                    $lastWords .= "\t" . $p->getFile() . ':' . $p->getLine() . \PHP_EOL;
                    $lastWords .= "\t" . $p->getTraceAsString() . \PHP_EOL;
                }
            }
            
            $this->terminateExecution( $lastWords );           
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    private function addDebugInfoToResponseHeaders( \Insomnia\Response $response, \Exception $e, $level = 1 )
    {        
        $response->setHeader( sprintf( 'X-Debug%d-Message', $level ), $e->getMessage() );
        $response->setHeader( sprintf( 'X-Debug%d-File', $level ), $e->getFile() . ':' . $e->getLine() );

        if( ( $p = $e->getPrevious() ) instanceof \Exception )
        {
            $this->addDebugInfoToResponseHeaders( $response, $p, ++$level );
        }
    }
    
    public function error( $errno, $errstr, $errfile, $errline )
    {
        if( isset( $errstr, $errno, $errfile, $errline ) )
        {
            // Do not halt script execution for all errors not in the currently 
            // defined error_reporting bitmask.
            if( error_reporting() & $errno )
            {
                return $this->catchException( new \ErrorException( $errstr, $errno, null, $errfile, $errline ) );
            }
            
            $this->log( $errstr );
        }        
        else
        {
            $this->log( 'Error Handler failed to get the required info from last error.' );
            $this->terminateExecution();
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    protected function log( $message, $exception = null )
    {
        // Extend and attach your logger
    }

    public function registerExceptionHandler()
    {
        set_exception_handler( array( $this, 'catchException' ) );
    }
    
    public function registerErrorHandler()
    {
        set_error_handler( array( $this, 'error' ), \E_ALL );
    }
    
    private function terminateExecution( $lastWords = '' )
    {
        header( 'Content-type: text/plain' );
        echo 'Service is currently unavailable, Please try again later.' . \PHP_EOL;
        if ( $lastWords !== '' )
        {
            echo $lastWords;
        }
        exit;
    }
}