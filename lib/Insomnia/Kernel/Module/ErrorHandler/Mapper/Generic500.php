<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 500 handler
 */
class Generic500 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_INTERNAL_SERVER_ERROR );
        $response[ 'status' ] = Code::HTTP_INTERNAL_SERVER_ERROR;
        $response[ 'title' ] = 'An error has occurred';
        $response[ 'body' ] = 'A unrecoverable system error has occurred';
    }
}