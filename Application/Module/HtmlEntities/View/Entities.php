<?php

namespace Application\Module\HtmlEntities\View;

use \Insomnia\Kernel\Module\Mime\View;

class Entities extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'entity' . \DIRECTORY_SEPARATOR . 'allentities.php' );
        $this->setPath( $view );
    }
}