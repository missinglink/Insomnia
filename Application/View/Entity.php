<?php

namespace Application\View;

use \Insomnia\Kernel\Module\Mime\View;

class Entity extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'entity' . \DIRECTORY_SEPARATOR . 'entity.php' );
        $this->setPath( $view );
    }
}