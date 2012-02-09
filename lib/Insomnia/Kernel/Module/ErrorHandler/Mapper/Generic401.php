<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 401 handler
 */
class Generic401 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_UNAUTHORIZED );
        $response[ 'status' ] = Code::HTTP_UNAUTHORIZED;
        $response[ 'title' ] = 'Authentication Failed';
        $response[ 'body' ] = 'Authentication is possible but has failed or not yet been provided';
    }
}