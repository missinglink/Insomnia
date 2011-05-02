<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Maps\Layout;

class TestController extends Action
{
    public function __construct()
    {
        parent::__construct();
        //$this->response->setContentType( 'application/json' );
    }
    
    public function render()
    {
        Layout::render( $this->request, $this->response );
    }
}