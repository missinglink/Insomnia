<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 413 handler
 */
class Generic413 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_REQUEST_ENTITY_TOO_LARGE );
        $response[ 'status' ] = Code::HTTP_REQUEST_ENTITY_TOO_LARGE;
        $response[ 'title' ] = 'Request Entity Too Large';
        $response[ 'body' ] = 'The server is refusing to process a request because the request entity is larger than the server is willing or able to process.';
    }
}