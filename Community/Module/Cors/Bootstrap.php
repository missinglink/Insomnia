<?php

namespace Community\Module\Cors;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia CORS module
 * 
 * Adds cross-origin-resources-sharing headers to all HTTP responses.
 * 
 * Insomnia\Annotation\:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * Insomnia\Annotation\:KernelPlugins({
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\CorsHeaders" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addResponsePlugin( new Response\Plugin\CorsHeaders );
    }
}