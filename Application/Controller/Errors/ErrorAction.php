<?php

namespace Application\Controller\Errors;

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
     * @insomnia:Route("/error", name="error")
     * @insomnia:Method("GET")
     *
     * @insomnia:View( "errors/error" )
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

            case 'Insomnia\Session\SessionException':
                $response->setCode( Code::HTTP_UNAUTHORIZED );
                $response[ 'status' ] = Code::HTTP_UNAUTHORIZED;
                $response[ 'title' ] = 'Authentication Failed';
                $response[ 'body' ] = 'Authentication is possible but has failed or not yet been provided';
                break;

            case 'Insomnia\Kernel\Module\RequestValidator\Request\ValidatorException':
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
            
//            echo '<pre>';
//            print_r( $debug[ 'backtrace' ] );
//            die;
            
            $debug[ 'routes' ] = \Insomnia\Kernel::getInstance()->getEndPoints();
            
            
//            echo '<pre>';
//            print_r( $debug[ 'backtrace' ] );
//            die;
            
            $response[ 'debug' ] = $debug;
        }
    }
}