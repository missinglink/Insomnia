<?php

namespace Community\Module\EasyXDM\View;

use \Insomnia\Kernel\Module\Mime\View;

class Name extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'easyXDM' . \DIRECTORY_SEPARATOR . 'name.php' );
        $this->setPath( $view );
    }
}