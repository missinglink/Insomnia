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
     */
    public function run()
    {
        Kernel::addRequestPlugin( new Request\Plugin\JsonParamParser );
        Kernel::addResponsePlugin( new Response\Plugin\ContentTypeSelector, 1 );
        Kernel::addResponsePlugin( new Response\Plugin\RendererSelector, 2 );
    }
}