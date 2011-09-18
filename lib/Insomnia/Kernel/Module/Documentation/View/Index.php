<?php

namespace Insomnia\Kernel\Module\Documentation\View;

use \Insomnia\Pattern\View;

class Index extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'documentation' . \DIRECTORY_SEPARATOR . 'index.php' );
        $this->setPath( $view );
    }
}