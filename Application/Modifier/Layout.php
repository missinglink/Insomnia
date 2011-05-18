<?php

namespace Application\Modifier;

use \Insomnia\Response\Modifier;

class Layout implements Modifier
{
    public function render( $response )
    {
        $response->expand( 'data' );

        $header = new Header;
        $header->render( $response );
    }
}
