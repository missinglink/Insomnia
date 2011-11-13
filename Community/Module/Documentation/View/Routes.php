<?php

namespace Community\Module\Documentation\View;

use \Insomnia\Kernel\Module\Mime\View;

class Routes extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'documentation' . \DIRECTORY_SEPARATOR . 'routes.php' );
        $this->setPath( $view );
    }
}