<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Insomnia\Controller\RestControllerInterface;

class ExamplesController extends ControllerAbstract
{
    public function create()
    {
        $this->response[ 'message' ] = 'Create';
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }

    public function read()
    {
        $this->response[ 'message' ] = 'Read ' . $this->request[ 'id' ];
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }

    public function update()
    {
        $this->response[ 'message' ] = 'Update ' . $this->request[ 'id' ];
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }

    public function delete()
    {
        $this->response[ 'message' ] = 'Delete' . $this->request[ 'id' ];
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }

    public function index()
    {
        $this->response[ 'message' ] = 'Index';
        $this->response[ 'request' ] = $this->request->toArray();
        return $this->response;
    }
}