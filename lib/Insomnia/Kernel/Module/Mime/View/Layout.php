<?php

namespace Insomnia\Kernel\Module\Mime\View;

use \Insomnia\Kernel\Module\Mime\Layout as BaseLayout;

class Layout extends BaseLayout
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'layout' . \DIRECTORY_SEPARATOR . 'layout.php' );
        $this->setPath( $view );
    }
}