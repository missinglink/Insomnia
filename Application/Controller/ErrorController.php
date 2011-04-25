<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Insomnia\Controller\RestControllerInterface,
    \Insomnia\Response\Code;

class ErrorController extends ControllerAbstract
{
    public function error()
    {
        $exception = $this->request[ 'exception' ];
        $this->response[ 'class' ] = get_class( $exception );

        switch( get_class( $exception ) )
        {
            case 'Insomnia\RouterException':
                $this->response->setCode( Code::HTTP_NOT_FOUND );
                $this->response[ 'title' ] = $exception->getMessage();
                $this->response[ 'message' ] = $exception->getMessage();
                $this->response[ 'trace' ] = $exception->getTrace();
                break;

            case 'Insomnia\DispatcherException':
                $this->response->setCode( Code::HTTP_METHOD_NOT_ALLOWED );
                $this->response[ 'title' ] = 'Controller Not Found';
                $this->response[ 'message' ] = $exception->getMessage();
                $this->response[ 'trace' ] = $exception->getTrace();
                break;

            default:
                $this->response->setCode( Code::HTTP_INTERNAL_SERVER_ERROR );
                $this->response[ 'title' ] = 'An Error Occurred';
                $this->response[ 'message' ] = $exception->getMessage();
                break;
        }

        return $this->response;
    }
}

