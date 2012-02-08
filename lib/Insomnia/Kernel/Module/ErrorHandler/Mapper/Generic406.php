<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 406 handler
 */
class Generic406 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_NOT_ACCEPTABLE );
        $response[ 'status' ] = Code::HTTP_NOT_ACCEPTABLE;
        $response[ 'title' ] = 'Not Acceptable';
        $response[ 'body' ] = 'The resource identified by the request is only capable of generating response entities which have content characteristics not acceptable according to the accept headers sent in the request.';
    }
}