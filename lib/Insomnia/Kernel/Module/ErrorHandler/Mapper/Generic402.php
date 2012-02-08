<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 402 handler
 */
class Generic402 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_PAYMENT_REQUIRED );
        $response[ 'status' ] = Code::HTTP_PAYMENT_REQUIRED;
        $response[ 'title' ] = 'Payment Required';
        $response[ 'body' ] = 'A payment is required';
    }
}