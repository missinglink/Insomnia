<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 403 handler
 */
class Generic403 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_FORBIDDEN );
        $response[ 'status' ] = Code::HTTP_FORBIDDEN;
        $response[ 'title' ] = 'Forbidden';
        $response[ 'body' ] = 'The server understood the request, but is refusing to fulfill it. Authorization will not help and the request SHOULD NOT be repeated.';
    }
}