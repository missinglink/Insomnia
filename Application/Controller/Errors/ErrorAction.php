<?php

namespace Application\Controller\Errors;

use \Application\Controller\ErrorsController,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Error Controller
 * 
 * @webservice:Resource
 * 
 */
class ErrorAction
{   
    /**
     * Map Errors to Output
     * 
     * @webservice:Route("/error", name="error")
     * @webservice:Method("GET")
     *
     * @webservice:View( "errors/error" )
     */
    public function action()
    {
        $response = new \Insomnia\Response;
        
        /* @var $exception \Exception */
        $exception = Registry::get( 'request' )->getParam( 'exception' );
        
        switch( \get_class( $exception ) )
        {
            case 'Insomnia\Router\RouterException':
            case 'Insomnia\DispatcherControllerException':
            case 'Insomnia\Controller\NotFoundException':
                $response->setCode( Code::HTTP_NOT_FOUND );
                $response[ 'status' ] = Code::HTTP_NOT_FOUND;
                $response[ 'title' ] = 'Resource Not Found';
                $response[ 'body' ] = 'The requested resource could not be found but may be available again in the future';
                break;

            case 'Insomnia\DispatcherMethodException':
                $response->setCode( Code::HTTP_METHOD_NOT_ALLOWED );
                $response[ 'status' ] = Code::HTTP_METHOD_NOT_ALLOWED;
                $response[ 'title' ] = 'Unsupported Method';
                $response[ 'body' ] = 'A request was made of a resource using a request method not supported by that resource';
                break;

            case 'Insomnia\SessionException':
                $response->setCode( Code::HTTP_UNAUTHORIZED );
                $response[ 'status' ] = Code::HTTP_UNAUTHORIZED;
                $response[ 'title' ] = 'Authentication Failed';
                $response[ 'body' ] = 'Authentication is possible but has failed or not yet been provided';
                break;

            case 'Insomnia\Request\ValidatorException':
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

            case 'ReflectionException':
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
                $previous[ 'message' ]          = $exception->getMessage();
                $debug[ 'previous' ]            = $previous;
            }
            
            $debug[ 'backtrace' ] = \debug_backtrace();
            $response[ 'debug' ] = $debug;
        }
        
        $response->render();
    }
}