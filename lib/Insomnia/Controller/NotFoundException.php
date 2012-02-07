<?php

namespace Insomnia\Controller;

class NotFoundException extends \Exception
{
    public function __construct( $message, $code = null, \Exception $previous = null )
    {
        parent::__construct( $message, 404, $previous );
    }
}