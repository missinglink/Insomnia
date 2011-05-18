<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Modifier\Layout;

class TestController extends Action
{
    public function __construct()
    {
        parent::__construct();
        //$this->response->setContentType( 'application/json' );
    }
    
    public function render()
    {
        $this->getResponse()->addModifier( new Layout );
    }
}