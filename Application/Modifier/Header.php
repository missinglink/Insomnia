<?php

namespace Application\Modifier;

use \Insomnia\Response\Modifier,
    \Insomnia\Registry;

class Header implements Modifier
{
    public function render( $response )
    {
        $header = array();
        $header[ 'Code' ]               = (int) \substr( $response->getCode(), 0, 3 );
        $header[ 'Content-Type' ]       = $response->getContentType() . '; charset=' . $response->getCharacterSet();

        /* @var $request \Insomnia\Request */
        $request = Registry::get( 'request' );
        if( $request->hasParam( 'version' ) )
            $header[ 'Version' ] = $request->getParam( 'version' );

        $response->prepend( 'meta', $header );
    }
}
