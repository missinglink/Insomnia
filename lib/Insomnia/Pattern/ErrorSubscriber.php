<?php

namespace Insomnia\Pattern;

use \Insomnia\Response;

abstract class ErrorSubscriber
{
    public function match( \Exception $exception, Response $response )
    {
        return false;
    }
}