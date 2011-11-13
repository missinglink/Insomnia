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
     *      @insomnia:DispatcherPlugin( class="Dispatcher\Plugin\DocumentationEndPoint" ),
     *      @insomnia:Endpoint( class="Controller\DocumentationController" ),
     *      @insomnia:Endpoint( class="Controller\PingController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\DocumentationController' );
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\PingController' );
    }
}