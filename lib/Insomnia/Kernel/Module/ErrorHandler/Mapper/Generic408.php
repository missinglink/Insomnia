<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 408 handler
 */
class Generic408 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_REQUEST_TIMEOUT );
        $response[ 'status' ] = Code::HTTP_REQUEST_TIMEOUT;
        $response[ 'title' ] = 'Request Timeout';
        $response[ 'body' ] = 'The client did not produce a request within the time that the server was prepared to wait.';
    }
}