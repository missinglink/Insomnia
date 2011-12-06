<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Controller;

use \Application\Controller\ErrorsController,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Error Controller
 * 
 * @insomnia:Resource
 * 
 */
class ErrorAction extends \Insomnia\Controller\Action
{   
    /**
     * Map Errors to Output
     * 
     * @insomnia:View( "Insomnia\Kernel\Module\ErrorHandler\View\Error" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     * @param \Exception $exception 
     */
    public function action( \Exception $exception )
    {        
        $response = $this->getResponse();
        
        switch( \get_class( $exception ) )
        {
            case 'Insomnia\Router\RouterException':
            case 'Insomnia\Router\DispatcherControllerException':
            case 'Insomnia\Controller\NotFoundException':
                $response->setCode( Code::HTTP_NOT_FOUND );
                $response[ 'status' ] = Code::HTTP_NOT_FOUND;
                $response[ 'title' ] = 'Resource Not Found';
                $response[ 'body' ] = 'The requested resource could not be found but may be available again in the future';
                break;

            case 'Insomnia\Router\DispatcherMethodException':
                $response->setCode( Code::HTTP_METHOD_NOT_ALLOWED );
                $response[ 'status' ] = Code::HTTP_METHOD_NOT_ALLOWED;
                $response[ 'title' ] = 'Unsupported Method';
                $response[ 'body' ] = 'A request was made of a resource using a request method not supported by that resource';
                break;

            case 'Community\Module\Session\SessionException':
                $response->setCode( Code::HTTP_UNAUTHORIZED );
                $response[ 'status' ] = Code::HTTP_UNAUTHORIZED;
                $response[ 'title' ] = 'Authentication Failed';
                $response[ 'body' ] = 'Authentication is possible but has failed or not yet been provided';
                break;

            case 'Community\Module\RequestValidator\Request\ValidatorException':
                $response->setCode( Code::HTTP_BAD_REQUEST );
                $response[ 'status' ] = Code::HTTP_BAD_REQUEST;
                $response[ 'title' ] = 'Missing or Invalid Request Parameter';
                $response[ 'body' ] = 'The request could not be understood by the server due to malformed syntax';
                $response[ 'parameter' ] = $exception->getMessage();
                break;
            
            case 'Insomnia\Validator\ErrorStack':
                $response->setCode( Code::HTTP_BAD_REQUEST );
                $response[ 'status' ] = Code::HTTP_BAD_REQUEST;
                $response[ 'title' ] = 'Missing or Invalid Request Parameter';
                $response[ 'body' ] = 'The request contained missing or invalid request parameters';
                $response[ 'errors' ] = $exception->getErrors();
                break;

            case 'Insomnia\Response\ResponseException':
                $response->setCode( Code::HTTP_UNSUPPORTED_MEDIA_TYPE );
                $response[ 'status' ] = Code::HTTP_UNSUPPORTED_MEDIA_TYPE;
                $response[ 'title' ] = 'Invalid Response Format';
                $response[ 'body' ] = 'Could not create a response with content characteristics acceptable according to the accept headers sent in the request';
                $response[ 'parameter' ] = $exception->getMessage();
                break;
            
            case 'Doctrine_Connection_Mysql_Exception':
                $response->setCode( Code::HTTP_CONFLICT );
                $response[ 'status' ] = Code::HTTP_CONFLICT;
                $response[ 'title' ] = 'HTTP Conflict';
                $response[ 'body' ] = 'The request could not be completed due to a conflict with the current state of the resource';
                $response[ 'parameter' ] = $exception->getMessage();
                break;

            case 'Insomnia\Response\Renderer\ViewException':
            case 'ReflectionException':
            case 'ErrorException':
            default:
                $response->setCode( Code::HTTP_INTERNAL_SERVER_ERROR );
                $response[ 'status' ] = Code::HTTP_INTERNAL_SERVER_ERROR;
                $response[ 'title' ] = 'Oops! an error has occurred';
                $response[ 'body' ] = 'A unrecoverable system error has occurred';
                break;
        }
        
        if( \APPLICATION_ENV === 'development' )
        {
            $debug = array();
            $debug[ 'exception' ]  = \get_class( $exception );
            $debug[ 'file' ]       = $exception->getFile();
            $debug[ 'line' ]       = $exception->getLine();
            $debug[ 'code' ]       = $exception->getCode();
            $debug[ 'message' ]    = $exception->getMessage();
            
            if( $prev = $exception->getPrevious() )
            {
                $previous = array();
                $previous[ 'exception' ]        = \get_class( $prev );
                $previous[ 'file' ]             = $prev->getFile();
                $previous[ 'line' ]             = $prev->getLine();
                $previous[ 'code' ]             = $prev->getCode();
                $previous[ 'message' ]          = $prev->getMessage();
                $debug[ 'previous' ]            = $previous;
            }
            
            if( is_array( $exception->getTrace() ) )
            {
                $debug[ 'backtrace' ] = array_reverse( array_merge( debug_backtrace(false), array( array( 'exception' => $exception ) ), $exception->getTrace() ) );
            }
            
            else {
                $debug[ 'backtrace' ] = array_reverse( debug_backtrace( false ) );
            }
            
            $debug[ 'routes' ] = \Insomnia\Kernel::getInstance()->getEndPoints();
            $debug[ 'requestPlugins' ] = \Insomnia\Kernel::getInstance()->getRequestPlugins();
            $debug[ 'responsePlugins' ] = \Insomnia\Kernel::getInstance()->getResponsePlugins();
            $debug[ 'dispatcherPlugins' ] = \Insomnia\Kernel::getInstance()->getDispatcherPlugins();
            $debug[ 'modules' ] = \Insomnia\Kernel::getInstance()->getModules();
            
            $response[ 'debug' ] = $debug;
        }
    }
}