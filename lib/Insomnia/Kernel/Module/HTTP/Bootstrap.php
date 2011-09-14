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
        
        $kernel->addResponsePlugin( new Response\Plugin\HttpHeaders );
        $kernel->addResponsePlugin( new Response\Plugin\CacheHeaders );
        $kernel->addResponsePlugin( new Response\Plugin\ResponseCodeSelector );
    }
}