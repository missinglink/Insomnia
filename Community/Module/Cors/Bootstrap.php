<?php

namespace Community\Module\Cors;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia CORS module
 * 
 * Adds cross-origin-resources-sharing headers to all HTTP responses.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:ResponsePlugin( class="Response\Plugin\CorsHeaders" )
     * })
     */
    public function run()
    {
        Kernel::addResponsePlugin( new Response\Plugin\CorsHeaders );
    }
}