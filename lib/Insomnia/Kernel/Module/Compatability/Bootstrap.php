<?php

namespace Insomnia\Kernel\Module\Compatability;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia compatibility modules.
 * 
 * Provides a compatibility layer for difficult clients.
 * 
 * @insomnia:Module
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
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\MethodOverride );
        $kernel->addResponsePlugin( new Response\Plugin\VersionHeaders );
    }
}