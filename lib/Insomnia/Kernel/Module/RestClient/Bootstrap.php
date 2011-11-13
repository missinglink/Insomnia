<?php

namespace Insomnia\Kernel\Module\RestClient;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia RestClient
 * 
 * Provides a basic rest client for testing.
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
     *      @insomnia:Endpoint( class="Controller\ClientController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\ClientController' );
    }
}