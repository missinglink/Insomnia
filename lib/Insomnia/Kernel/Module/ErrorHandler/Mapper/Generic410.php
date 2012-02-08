<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 410 handler
 */
class Generic410 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_GONE );
        $response[ 'status' ] = Code::HTTP_GONE;
        $response[ 'title' ] = 'Gone';
        $response[ 'body' ] = 'The requested resource is no longer available at the server and no forwarding address is known.';
    }
}