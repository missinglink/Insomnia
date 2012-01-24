<?php

namespace Insomnia\Kernel\Module\HTTP;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia core HTTP module
 * 
 * Provides basic HTTP/1.1 functionality.
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
     *      @insomnia:RequestPlugin( class="Request\Plugin\UriParser" ),
     *      @insomnia:RequestPlugin( class="Request\Plugin\HeaderParser" ),
     *      @insomnia:RequestPlugin( class="Request\Plugin\BodyParser" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\HttpHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ContentTypeHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\CacheHeaders" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ResponseCodeSelector" ),
     *      @insomnia:Endpoint( class="Controller\ClientController" )
     * })
     */
    public function run()
    {
        Kernel::addRequestPlugin( new Request\Plugin\ParamParser );
        Kernel::addRequestPlugin( new Request\Plugin\UriParser );
        Kernel::addRequestPlugin( new Request\Plugin\HeaderParser );
        Kernel::addRequestPlugin( new Request\Plugin\BodyParser );
        
        Kernel::addResponsePlugin( new Response\Plugin\HttpHeaders, -999 ); // Setting HTTP header causes a bug with ini & yaml filetypes
        Kernel::addResponsePlugin( new Response\Plugin\ContentTypeHeaders, 999 );
        Kernel::addResponsePlugin( new Response\Plugin\CacheHeaders, 998 );
        Kernel::addResponsePlugin( new Response\Plugin\ResponseCodeSelector, 997 );
        
        Kernel::addEndPoint( __NAMESPACE__ . '\Controller\OptionsController' );
    }
}