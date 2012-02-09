<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

class ViewException extends \Exception
{
    public function __construct( $message, $code = null, \Exception $previous = null )
    {
        parent::__construct( $message, 415, $previous );
    }
}