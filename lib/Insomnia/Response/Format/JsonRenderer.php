<?php

namespace Insomnia\Response\Format;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class JsonRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        header( 'Content-Type: application/json' );
        echo json_encode( $response->toArray() );
    }
}