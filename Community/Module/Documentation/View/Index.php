<?php

namespace Community\Module\Documentation\View;

use \Insomnia\Kernel\Module\Mime\View;

class Index extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'documentation' . \DIRECTORY_SEPARATOR . 'index.php' );
        $this->setPath( $view );
    }
}