<?php

namespace Community\Module\Compatibility;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia compatibility modules.
 * 
 * Provides a compatibility layer for difficult clients.
 * 
 * Insomnia\Annotation\:Module
 * @beta
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * Insomnia\Annotation\:KernelPlugins({
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\MethodOverride" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\VersionHeaders" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\MethodOverride );
        $kernel->addResponsePlugin( new Response\Plugin\VersionHeaders );
    }
}