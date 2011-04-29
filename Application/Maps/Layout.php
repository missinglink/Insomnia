<?php

namespace Application\Maps;

use \Insomnia\Response;

class Layout implements \Insomnia\Response\Map
{
    public static $request, $response;

    public static function render( $request, $response )
    {
        self::$request  = $request;
        self::$response = $response;
        
        self::$response->expand( 'data' );
        self::prependHeader();
    }

    private static function prependHeader( )
    {
        $header = array();
        $header[ 'Code' ]           = (int) substr( self::$response->getCode(), 0, 3 );
        $header[ 'Content-Type' ]   = self::$response->getContentType();
        $header[ 'Character-Set' ]  = self::$response->getCharacterSet();

        if( self::$request[ 'version' ] )
            $header[ 'Version' ]    = self::$request[ 'version' ];

        self::$response->prepend( 'meta', $header );
    }
}
