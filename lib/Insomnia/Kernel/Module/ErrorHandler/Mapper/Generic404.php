<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 404 handler
 */
class Generic404 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_NOT_FOUND );
        $response[ 'status' ] = Code::HTTP_NOT_FOUND;
        $response[ 'title' ] = 'Resource Not Found';
        $response[ 'body' ] = 'The requested resource could not be found but may be available again in the future';
    }
}