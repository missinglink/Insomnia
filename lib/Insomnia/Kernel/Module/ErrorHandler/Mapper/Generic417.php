<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 417 handler
 */
class Generic417 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_EXPECTATION_FAILED );
        $response[ 'status' ] = Code::HTTP_EXPECTATION_FAILED;
        $response[ 'title' ] = 'Expectation Failed';
        $response[ 'body' ] = 'The expectation given in an Expect request-header field could not be met by this server.';
    }
}