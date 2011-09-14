<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class ArrayRenderer implements ResponseInterface
{
    public function render( Response $response )
    {
        \print_r( $response->toArray() );
    }
}