<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function catchException( \Exception $e )
    {
        try
        {
            $endPoint = new EndPoint( 'Insomnia\Kernel\Module\ErrorHandler\Controller\ErrorAction', 'action' );
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
    
    public function error( $errno, $errstr, $errfile, $errline )
    {
        if( isset( $errstr, $errno, $errfile, $errline ) )
        {
            // Do not halt script execution for all errors not in the currently 
            // defined error_reporting bitmask.
            if( error_reporting() & $errno )
            {
                return $this->catchException( new \ErrorException( $errstr, $errno, 2, $errfile, $errline ) );
            }
        }        
        else
        {
            $this->terminateExecution();
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    public function useBuffer()
    {
        $this->cleanBuffer();
        ob_start( array( $this, 'test' ) );
    }
    
    private function cleanBuffer()
    {
        $buffer = '';
        while( $buf = ob_end_clean() )
        {
            $buffer .= $buf;
        }
        
        return $buffer;
    }
    
    public function test()
    {
        $this->cleanBuffer();
        
//        $this->catchException( new \ErrorException( 'a', 1, 2, '$errfile', 1 ) );
        return 'BUFFER!';
    }

    public function registerExceptionHandler()
    {
        set_exception_handler( array( $this, 'catchException' ) );
    }
    
    public function registerErrorHandler()
    {
        set_error_handler( array( $this, 'error' ), \E_ALL | \E_STRICT );
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