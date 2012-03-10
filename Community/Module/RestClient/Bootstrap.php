<?php

namespace Community\Module\RestClient;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia RestClient
 * 
 * Provides a basic rest client for testing.
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
     *      Insomnia\Annotation\:Endpoint( class="Controller\ClientController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\ClientController' );
    }
}