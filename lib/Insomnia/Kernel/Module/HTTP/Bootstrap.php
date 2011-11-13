<?php

namespace Insomnia\Kernel\Module\HTTP;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia core HTTP module
 * 
 * Provides basic HTTP 1.1 functionality.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:RequestPlugin( class="Request\Plugin\ParamParser" ),
     *      @insomnia:RequestPlugin( class="Request\Plugin\HeaderParser" ),
     *      @insomnia:RequestPlugin( class="Request\Plugin\BodyParser" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\HttpHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ContentTypeHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\CacheHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ResponseCodeSelector" )
     * })
     * 
     * @param Kernel $kernel
     */
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