<?php

namespace Insomnia\Pattern;

use \Insomnia\Pattern\View;

abstract class Layout extends View
{
    protected $view;
    
    public function getView()
    {
        return $this->view;
    }

    public function setView( View $view )
    {
        $this->view = $view;
    }
}