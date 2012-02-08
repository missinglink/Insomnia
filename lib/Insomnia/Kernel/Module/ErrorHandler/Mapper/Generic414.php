<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 414 handler
 */
class Generic414 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_REQUEST_URI_TOO_LONG );
        $response[ 'status' ] = Code::HTTP_REQUEST_URI_TOO_LONG;
        $response[ 'title' ] = 'Request-URI Too Long';
        $response[ 'body' ] = 'The server is refusing to service the request because the Request-URI is longer than the server is willing to interpret.';
    }
}