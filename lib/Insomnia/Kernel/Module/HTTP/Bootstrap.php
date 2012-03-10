<?php

namespace Insomnia\Kernel\Module\HTTP;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia core HTTP module
 * 
 * Provides basic HTTP/1.1 functionality.
 * 
 * Insomnia\Annotation\:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * Insomnia\Annotation\:KernelPlugins({
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\ParamParser" ),
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\UriParser" ),
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\HeaderParser" ),
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\BodyParser" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\HttpHeaders" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\ContentTypeHeaders" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\CacheHeaders" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\ResponseCodeSelector" ),
     *      Insomnia\Annotation\:Endpoint( class="Controller\ClientController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\ParamParser );
        $kernel->addRequestPlugin( new Request\Plugin\UriParser );
        $kernel->addRequestPlugin( new Request\Plugin\HeaderParser );
        $kernel->addRequestPlugin( new Request\Plugin\BodyParser );
        
        $kernel->addResponsePlugin( new Response\Plugin\HttpHeaders, -999 ); // Setting HTTP header causes a bug with ini & yaml filetypes
        $kernel->addResponsePlugin( new Response\Plugin\ContentTypeHeaders, 999 );
        $kernel->addResponsePlugin( new Response\Plugin\CacheHeaders, 998 );
        $kernel->addResponsePlugin( new Response\Plugin\ResponseCodeSelector, 997 );
        
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\OptionsController' );
    }
}