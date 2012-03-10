<?php

namespace Insomnia\Kernel\Module\Mime;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia core MIME module
 * 
 * Provides basic MIME functionality.
 * 
 * @Insomnia\Annotation\Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @Insomnia\Annotation\KernelPlugins({
     *      @Insomnia\Annotation\RequestPlugin( class="Request\Plugin\JsonParamParser" ),
     *      @Insomnia\Annotation\ResponsePlugin( class="Response\Plugin\ContentTypeSelector" ),
     *      @Insomnia\Annotation\ResponsePlugin( class="Response\Plugin\RendererSelector" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\JsonParamParser );
        $kernel->addResponsePlugin( new Response\Plugin\ContentTypeSelector, 1 );
        $kernel->addResponsePlugin( new Response\Plugin\RendererSelector, 2 );
    }
}