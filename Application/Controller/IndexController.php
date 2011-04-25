<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Insomnia\Controller\RestControllerInterface;

class IndexController extends ControllerAbstract
{
    public function index()
    {
        $this->response[ 'message' ] = 'Index';
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }
}