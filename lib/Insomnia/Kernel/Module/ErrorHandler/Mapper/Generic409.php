<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 409 handler
 */
class Generic409 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_CONFLICT );
        $response[ 'status' ] = Code::HTTP_CONFLICT;
        $response[ 'title' ] = 'HTTP Conflict';
        $response[ 'body' ] = 'The request could not be completed due to a conflict with the current state of the resource';
    }
}