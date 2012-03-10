<?php

namespace Insomnia\Kernel\Module\ErrorHandler;

use \Insomnia\Dispatcher\EndPoint;

class Hiccup
{
    public function onException( \Exception $e )
    {
        try
        {
            $endPoint = new EndPoint( 'Insomnia\Kernel\Module\ErrorHandler\Controller\ErrorAction', 'action' );
            
            if( \APPLICATION_ENV === 'development' )
            {
                $endPoint->getController()->getResponse()->setHeader( 'X-Debug-Message', $e->getMessage() );
                $endPoint->getController()->getResponse()->setHeader( 'X-Debug-File', $e->getFile() . ':' . $e->getLine() );
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
            
            $this->failWhale( $lastWords );           
        }
        
        /* Script execution will now terminate. */
    }
    
    public function onError( $errno, $errstr, $errfile, $errline )
    {
        if( isset( $errno, $errstr, $errfile, $errline ) )
        {
            // Do not halt script execution for errors not in the error_reporting bitmask.
            if( error_reporting() & $errno )
            {
                return $this->onException( new \ErrorException( $errstr, $errno, \E_ERROR, $errfile, $errline ) );
            }
        }
        
        else
        {
            $this->failWhale();
        }
        
        /* Don't execute PHP internal error handler */
        return true;
    }

    public function registerExceptionHandler()
    {
        set_exception_handler( array( $this, 'onException' ) );
    }
    
    public function registerErrorHandler()
    {
        set_error_handler( array( $this, 'onError' ), \E_ALL );
    }
    
    /*
     * Something really bad just happened
     * 
     *  ▄██████████████▄▐█▄▄▄▄█▌
     *  ██████▌▄▌▄▐▐▌███▌▀▀██▀▀ 
     *  ████▄█▌▄▌▄▐▐▌▀███▄▄█▌
     *  ▄▄▄▄▄██████████████▀
     * 
     */
    private function failWhale( $lastWords = '' )
    {
        header( 'Content-type: text/plain' );
        echo 'Service is currently unavailable, Please try again later.' . \PHP_EOL;
        
        if ( is_string( $lastWords ) && !empty( $lastWords ) )
        {
            echo $lastWords;
        }
        
        exit;
    }
}