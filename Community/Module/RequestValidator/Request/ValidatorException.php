<?php

namespace Community\Module\RequestValidator\Request;

class ValidatorException extends \Exception
{
    public function __construct( $message, $code = null, \Exception $previous = null )
    {
        parent::__construct( $message, 400, $previous );
    }
}