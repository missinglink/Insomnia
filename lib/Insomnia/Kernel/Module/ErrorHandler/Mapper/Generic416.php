<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 416 handler
 */
class Generic416 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE );
        $response[ 'status' ] = Code::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE;
        $response[ 'title' ] = 'Requested Range Not Satisfiable';
        $response[ 'body' ] = 'Requested Range Not Satisfiable.';
    }
}