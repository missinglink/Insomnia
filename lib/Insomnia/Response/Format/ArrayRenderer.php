<?php

namespace Insomnia\Response\Format;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class ArrayRenderer implements ResponseInterface
{
    private $strip = array();

    public function render( Response $response )
    {
        header( 'Content-Type: text/html' );
        echo '<html><body><pre>';
        print_r( $response->toArray() );
        echo '</pre></body></html>';
    }
}