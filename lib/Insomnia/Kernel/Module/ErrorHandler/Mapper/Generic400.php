<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 400 handler
 */
class Generic400 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_BAD_REQUEST );
        $response[ 'status' ] = Code::HTTP_BAD_REQUEST;
        $response[ 'title' ] = 'Missing or Invalid Request Parameter';
        $response[ 'body' ] = 'The request could not be understood by the server due to malformed syntax';
    }
}