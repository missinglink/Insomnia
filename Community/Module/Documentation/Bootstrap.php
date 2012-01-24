<?php

namespace Community\Module\Documentation;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia documentation module
 * 
 * Provides an interface to auto-generate documentation.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:Endpoint( class="Controller\DocumentationController" ),
     *      @insomnia:Endpoint( class="Controller\PingController" )
     * })
     */
    public function run()
    {
        Kernel::addEndPoint( __NAMESPACE__ . '\Controller\DocumentationController' );
        Kernel::addEndPoint( __NAMESPACE__ . '\Controller\PingController' );
    }
}