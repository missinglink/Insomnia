<?php

namespace Insomnia;

class Error
{
    public function __construct( \Exception $e )
    {
        \header( $_SERVER["SERVER_PROTOCOL"]." 404 Not Found" );
        
        echo 'FAIL!' . \PHP_EOL;
        echo $e->getMessage() . \PHP_EOL;
    }
}