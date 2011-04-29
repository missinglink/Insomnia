<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Insomnia\Controller\RestControllerInterface,
    \Insomnia\Response\Code;

class ErrorsController extends ControllerAbstract
{
    public function error()
    {
        $exception = $this->request[ 'exception' ];
        //$this->response[ 'type2' ] = get_class( $exception );

        switch( get_class( $exception ) )
        {
            case 'Insomnia\Router\RouterException':
            case 'Insomnia\DispatcherControllerException':
            case 'Insomnia\Controller\NotFoundException':
                $this->response->setCode( Code::HTTP_NOT_FOUND );
                $this->response[ 'error' ] = Code::HTTP_NOT_FOUND;
                $this->response[ 'title' ] = 'Resource Not Found';
                $this->response[ 'body' ] = 'The requested resource could not be found but may be available again in the future';
                break;

            case 'Insomnia\DispatcherMethodException':
                $this->response->setCode( Code::HTTP_METHOD_NOT_ALLOWED );
                $this->response[ 'error' ] = Code::HTTP_METHOD_NOT_ALLOWED;
                $this->response[ 'title' ] = 'Unsupported Method';
                $this->response[ 'body' ] = 'A request was made of a resource using a request method not supported by that resource';
                break;

            case 'Insomnia\SessionException':
                $this->response->setCode( Code::HTTP_UNAUTHORIZED );
                $this->response[ 'error' ] = Code::HTTP_UNAUTHORIZED;
                $this->response[ 'title' ] = 'Authentication Failed';
                $this->response[ 'body' ] = 'Authentication is possible but has failed or not yet been provided';
                break;

            case 'Insomnia\Request\ValidatorException':
                $this->response->setCode( Code::HTTP_BAD_REQUEST );
                $this->response[ 'error' ] = Code::HTTP_BAD_REQUEST;
                $this->response[ 'title' ] = 'Missing or Invalid Request Parameter';
                $this->response[ 'parameter' ] = $exception->getMessage();
                $this->response[ 'body' ] = 'The request cannot be fulfilled due to bad syntax';
                break;
            
            default:
                $this->response->setCode( Code::HTTP_INTERNAL_SERVER_ERROR );
                $this->response[ 'error' ] = 'General Error';
                $this->response[ 'title' ] = $exception->getMessage();
                $this->response[ 'body' ] = 'A system error has occurred';
                break;
        }

        return $this->response;
    }
}

