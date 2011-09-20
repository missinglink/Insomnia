<?php

namespace Insomnia\Kernel\Module\RestClient\View;

use \Insomnia\Pattern\View;

class Client extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'client' . \DIRECTORY_SEPARATOR . 'client.php' );
        $this->setPath( $view );
    }
}