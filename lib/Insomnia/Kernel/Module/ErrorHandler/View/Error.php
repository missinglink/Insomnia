<?php

namespace Insomnia\Kernel\Module\ErrorHandler\View;

use \Insomnia\Kernel\Module\Mime\View;

class Error extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'errors' . \DIRECTORY_SEPARATOR . 'error.php' );
        $this->setPath( $view );
    }
}