<?php

namespace Insomnia\Response\Format;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class ArrayRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        \print_r( $response->toArray() );
    }
}