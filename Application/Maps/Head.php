<?php

namespace Application\Maps;

use \Insomnia\Response;

class Head implements \Insomnia\Response\Map
{
    public static function __callStatic()
    {
        $response = \func_get_arg( 0 );
        $response->set( 'head', 'hello' );
    }
}
