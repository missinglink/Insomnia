<?php

namespace Community\Module\Compatibility;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia compatibility modules.
 * 
 * Provides a compatibility layer for difficult clients.
 * 
 * @insomnia:Module
 * @beta
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:RequestPlugin( class="Request\Plugin\MethodOverride" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\VersionHeaders" )
     * })
     */
    public function run()
    {
        Kernel::addRequestPlugin( new Request\Plugin\MethodOverride );
        Kernel::addResponsePlugin( new Response\Plugin\VersionHeaders );
    }
}