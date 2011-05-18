<?php

namespace Insomnia\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response,
    \Insomnia\Registry;

class JsonRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        $jsonpCallback = Registry::get( 'jsonp_callback_param' );
        
        if( null !== $jsonpCallback && Registry::get( 'request' )->hasParam( $jsonpCallback ) )
        {
            echo Registry::get( 'request' )->getParam( $jsonpCallback );
            echo '(' . \json_encode( $response->toArray() ) . ')';
        }

        else echo \json_encode( $response->toArray() );
    }
}