<?php

namespace Community\Module\Session;

class SessionException extends \Exception
{
    public function __construct( $message, $code = null, \Exception $previous = null )
    {
        parent::__construct( $message, 401, $previous );
    }
}