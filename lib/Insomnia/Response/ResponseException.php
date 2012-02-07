<?php

namespace Insomnia\Response;

class ResponseException extends \Exception
{
    public function __construct( $message, $code = null, \Exception $previous = null )
    {
        parent::__construct( $message, 415, $previous );
    }
}