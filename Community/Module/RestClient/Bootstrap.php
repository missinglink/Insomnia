<?php

namespace Community\Module\RestClient;

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
     */
    public function run()
    {
        Kernel::addEndPoint( __NAMESPACE__ . '\Controller\ClientController' );
    }
}