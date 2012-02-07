<?php

namespace Insomnia\Kernel\Module\ErrorHandler\Mapper;

use \Insomnia\Pattern\Mapper,
    \Insomnia\Response,
    \Insomnia\Response\Code;

/**
 * Default 407 handler
 */
class Generic407 implements Mapper
{
    public function map( Response $response )
    {
        $response->setCode( Code::HTTP_PROXY_AUTHENTICATION_REQUIRED );
        $response[ 'status' ] = Code::HTTP_PROXY_AUTHENTICATION_REQUIRED;
        $response[ 'title' ] = 'Proxy Authentication Required';
        $response[ 'body' ] = 'You must first authenticate with the proxy.';
    }
}