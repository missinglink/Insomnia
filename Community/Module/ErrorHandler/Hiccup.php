<?php

namespace Community\Module\ErrorHandler;

class Hiccup extends \Insomnia\Kernel\Module\ErrorHandler\Hiccup
{   
    protected function log( $message, $level = 2, $exception = null )
    {
        \BNT\Utils\Logger::log( $message, $level, $exception );
    }
}