<?php

namespace Application\Module\HtmlEntities\View;

use \Insomnia\Kernel\Module\Mime\View;

class Raw extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'entity' . \DIRECTORY_SEPARATOR . 'raw.php' );
        $this->setPath( $view );
    }
}