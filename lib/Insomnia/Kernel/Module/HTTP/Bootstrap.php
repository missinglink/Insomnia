<?php

namespace Insomnia\Kernel\Module\HTTP;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\ParamParser );
        $kernel->addRequestPlugin( new Request\Plugin\HeaderParser );
        $kernel->addRequestPlugin( new Request\Plugin\BodyParser );
        
        $kernel->addResponsePlugin( new Response\Plugin\HttpHeaders, -999 ); // Setting HTTP header causes a bug with ini & yaml filetypes
        $kernel->addResponsePlugin( new Response\Plugin\ContentTypeHeaders, 999 );
        $kernel->addResponsePlugin( new Response\Plugin\CacheHeaders, 998 );
        $kernel->addResponsePlugin( new Response\Plugin\ResponseCodeSelector, 997 );
    }
}