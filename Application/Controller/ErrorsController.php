<?php

namespace Application\Controller;

use \Insomnia\Response,
    \Insomnia\Request,
    \Insomnia\Controller\Action,
    \Application\Maps\Layout;

class ErrorsController extends Action
{
    public function render()
    {
        Layout::render( $this->request, $this->response );
    }
}