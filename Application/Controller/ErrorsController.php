<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Maps\Layout;

class ErrorsController extends Action
{
    public function render()
    {
        Layout::render( $this->response );
    }
}