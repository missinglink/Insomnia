<?php

namespace Application\Maps;

use \Insomnia\Response\Map;

class Header implements Map
{
    public static function render( $request, $response )
    {
        $header = array();
        $header[ 'Code' ]               = (int) \substr( $response->getCode(), 0, 3 );
        $header[ 'Content-Type' ]       = $response->getContentType() . '; charset=' . $response->getCharacterSet();

        if( isset( $request[ 'version' ] ) )
            $header[ 'Version' ] = $request[ 'version' ];

        $response->prepend( 'meta', $header );
    }
}
