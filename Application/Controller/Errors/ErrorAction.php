<?php

namespace Application\Controller\Errors;

use \Application\Controller\ErrorsController,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

class ErrorAction extends ErrorsController
{
    public function action()
    {
        $request = Registry::get( 'request' );
        $exception = $request[ 'exception' ];
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
                $this->response[ 'body' ] = 'The request could not be understood by the server due to malformed syntax';
                break;

            case 'Insomnia\Response\ResponseException':
                $this->response->setCode( Code::HTTP_NOT_ACCEPTABLE );
                $this->response[ 'error' ] = Code::HTTP_NOT_ACCEPTABLE;
                $this->response[ 'title' ] = 'Invalid Response Format';
                $this->response[ 'parameter' ] = $exception->getMessage();
                $this->response[ 'body' ] = 'Could not create a response with content characteristics acceptable according to the accept headers sent in the request';
                break;

            default:
                $this->response->setCode( Code::HTTP_INTERNAL_SERVER_ERROR );
                $this->response[ 'error' ] = 'General Error';
                $this->response[ 'title' ] = $exception->getMessage();
                $this->response[ 'body' ] = 'A system error has occurred';
                break;
        }
    }
}