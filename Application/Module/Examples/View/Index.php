<?php

namespace Application\Module\Examples\View;

use \Insomnia\Kernel\Module\Mime\View;

class Index extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'index' . \DIRECTORY_SEPARATOR . 'index.php' );
        $this->setPath( $view );
    }
}