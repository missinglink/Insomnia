<?php

namespace Application\View;

use \Insomnia\Kernel\Module\Mime\Layout;

class EntityLayout extends Layout
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'entity' . \DIRECTORY_SEPARATOR . 'layout.php' );
        $this->setPath( $view );
    }
}