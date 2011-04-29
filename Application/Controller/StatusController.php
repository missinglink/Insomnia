<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Insomnia\Controller\RestControllerInterface,
    \Application\Bootstrap\Doctrine,
    \Insomnia\Session\Manager;

class StatusController extends ControllerAbstract
{
    public function status()
    {
        $this->request->getHeader( 'Load' );
        $request = $this->request->toArray( );
        $this->response->merge( $request[ 'headers' ] );
        $this->response->setContentType( 'message/http' );
        return $this->response;
    }
}