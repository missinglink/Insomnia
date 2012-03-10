<?php

namespace Application\Module\RedisExample\View;

use \Insomnia\Kernel\Module\Mime\View;

class Setup extends View
{
    public function __construct()
    {
        $view = realpath( __DIR__ . \DIRECTORY_SEPARATOR . 'setup' . \DIRECTORY_SEPARATOR . 'setup.php' );
        $this->setPath( $view );
    }
}