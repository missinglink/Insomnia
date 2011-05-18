<?php

namespace Application\Modifier;

use \Insomnia\Response\Modifier,
    \Insomnia\Registry;

class Header implements Modifier
{
    public function render( $response )
    {
        $headers = array();
        foreach( \headers_list() as $header )
            $headers[ \strstr( $header, ':', true ) ] = \substr( \strstr( $header, ':' ), 2 );

        \ksort( $headers );
        $headers = array( 'Code' => (int) \substr( $response->getCode(), 0, 3 ) ) + $headers;

        $response->prepend( 'meta', $headers );
    }
}
