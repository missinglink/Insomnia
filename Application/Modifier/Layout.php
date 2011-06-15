<?php

namespace Application\Modifier;

use \Insomnia\Response\Modifier;
use \Insomnia\Registry;

class Layout implements Modifier
{
    public function render( $response )
    {
        $response->expand( 'response' );

        if( Registry::get( 'request' )->hasParam( '_meta' ) )
        {                
            $header = new Header;
            $header->render( $response );
        }
    }
}
