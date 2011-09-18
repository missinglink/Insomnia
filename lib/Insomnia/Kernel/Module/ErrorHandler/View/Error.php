<?php

namespace Insomnia\Kernel\Module\ErrorHandler\View;

use \Insomnia\Pattern\Layout as BaseLayout;

class Error extends BaseLayout
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'errors' . \DIRECTORY_SEPARATOR . 'error.php' );
        $this->setPath( $view );
    }
}