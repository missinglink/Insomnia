<?php

namespace Insomnia\Kernel\Module\Mime;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia core MIME module
 * 
 * Provides basic MIME functionality.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:RequestPlugin( class="Request\Plugin\JsonParamParser" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ContentTypeSelector" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\RendererSelector" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\JsonParamParser );
        $kernel->addResponsePlugin( new Response\Plugin\ContentTypeSelector, 1 );
        $kernel->addResponsePlugin( new Response\Plugin\RendererSelector, 2 );
    }
}