<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 405 handler
 */
class Generic405 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_METHOD_NOT_ALLOWED );
        $response[ 'status' ] = Code::HTTP_METHOD_NOT_ALLOWED;
        $response[ 'title' ] = 'Unsupported Method';
        $response[ 'body' ] = 'A request was made of a resource using a request method not supported by that resource';
    }
}