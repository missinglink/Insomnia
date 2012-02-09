<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 411 handler
 */
class Generic411 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_LENGTH_REQUIRED );
        $response[ 'status' ] = Code::HTTP_LENGTH_REQUIRED;
        $response[ 'title' ] = 'Length Required';
        $response[ 'body' ] = 'The server refuses to accept the request without a defined Content-Length.';
    }
}