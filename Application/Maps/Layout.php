<?php

namespace Application\Maps;

use \Insomnia\Response\Map;

class Layout implements Map
{
    public static function render( $request, $response )
    {
        $response->expand( 'data' );

        $header = new Header;
        $header->render( $request, $response );
    }
}
