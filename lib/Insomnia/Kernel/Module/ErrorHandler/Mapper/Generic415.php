<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 415 handler
 */
class Generic415 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_UNSUPPORTED_MEDIA_TYPE );
        $response[ 'status' ] = Code::HTTP_UNSUPPORTED_MEDIA_TYPE;
        $response[ 'title' ] = 'Invalid Response Format';
        $response[ 'body' ] = 'Could not create a response with content characteristics acceptable according to the accept headers sent in the request';
    }
}