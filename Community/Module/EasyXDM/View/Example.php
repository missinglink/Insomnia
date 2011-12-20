<?php

namespace Community\Module\EasyXDM\View;

use \Insomnia\Kernel\Module\Mime\View;

class Example extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'easyXDM' . \DIRECTORY_SEPARATOR . 'example.php' );
        $this->setPath( $view );
    }
}