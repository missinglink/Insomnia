<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Modifier\Layout;

class ErrorsController extends Action
{
    public function render()
    {
        $this->getResponse()->addModifier( new Layout );
    }
}