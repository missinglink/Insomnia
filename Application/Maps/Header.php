<?php

namespace Application\Maps;

use \Insomnia\Response\Map,
    \Insomnia\Registry;

class Header implements Map
{
    public static function render( $response )
    {
        $header = array();
        $header[ 'Code' ]               = (int) \substr( $response->getCode(), 0, 3 );
        $header[ 'Content-Type' ]       = $response->getContentType() . '; charset=' . $response->getCharacterSet();

        $request = Registry::get( 'request' );
        if( isset( $request[ 'version' ] ) )
            $header[ 'Version' ] = $request[ 'version' ];

        $response->prepend( 'meta', $header );
    }
}
