<?php

namespace Application\Controller;

use \Insomnia\Controller\Action;

class ClientController extends Action
{
    public function __construct()
    {
        parent::__construct();
        $this->response->setContentType( 'text/html' );
    }

    public function action()
    {
        $this->response[ 'controllers' ] = array( '/v1/test', '/ping' );
    }
}