<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 412 handler
 */
class Generic412 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_PRECONDITION_FAILED );
        $response[ 'status' ] = Code::HTTP_PRECONDITION_FAILED;
        $response[ 'title' ] = 'Precondition Failed';
        $response[ 'body' ] = 'The precondition given in one or more of the request-header fields evaluated to false when it was tested on the server.';
    }
}