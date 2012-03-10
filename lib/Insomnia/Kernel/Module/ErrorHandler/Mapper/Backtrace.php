<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper;
use \Insomnia\Response\Code;
use \Insomnia\Response;

/**
 * Backtrace debugger
 */
class Backtrace implements Mapper
{
    private $exception;

    public function __construct( \Exception $e, $applicationEnv = 'production' )
    {
        $this->setException( $e );
    }

    public function map( Response $response )
    {
        if( \APPLICATION_ENV === 'development' )
        {
            $exception = $this->getException();

            $debug = array();
            $debug[ 'exception' ]  = get_class( $exception );
            $debug[ 'file' ]       = $exception->getFile();
            $debug[ 'line' ]       = $exception->getLine();
            $debug[ 'code' ]       = $exception->getCode();
            $debug[ 'message' ]    = $exception->getMessage();

            if( $exception->getPrevious() )
            {
                $prev = $exception;
                $debug[ 'previous' ] = array();

                while( $prev = $prev->getPrevious() )
                {
                    $previous = array();
                    $previous[ 'exception' ]        = get_class( $prev );
                    $previous[ 'file' ]             = $prev->getFile();
                    $previous[ 'line' ]             = $prev->getLine();
                    $previous[ 'code' ]             = $prev->getCode();
                    $previous[ 'message' ]          = $prev->getMessage();
                    $debug[ 'previous' ][]          = $previous;
                }
            }

            if( is_array( $exception->getTrace() ) )
            {
                $debug[ 'backtrace' ] = array_reverse( array_merge( debug_backtrace(false), array( array( 'exception' => $exception ) ), $exception->getTrace() ) );
            }

            else {
                $debug[ 'backtrace' ] = array_reverse( debug_backtrace( false ) );
            }

//            $debug[ 'routes' ] = \Insomnia\Kernel::getInstance()->getEndPoints();
//            $debug[ 'requestPlugins' ] = \Insomnia\Kernel::getInstance()->getRequestPlugins();
//            $debug[ 'responsePlugins' ] = \Insomnia\Kernel::getInstance()->getResponsePlugins();
//            $debug[ 'dispatcherPlugins' ] = \Insomnia\Kernel::getInstance()->getDispatcherPlugins();
//            $debug[ 'modules' ] = \Insomnia\Kernel::getInstance()->getModules();

            $response[ 'debug' ] = $debug;
        }

        return false;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException( $exception )
    {
        $this->exception = $exception;
    }
}