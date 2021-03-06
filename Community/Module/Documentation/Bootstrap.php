<?php

namespace Community\Module\Documentation;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia documentation module
 * 
 * Provides an interface to auto-generate documentation.
 * 
 * @Insomnia\Annotation\Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @Insomnia\Annotation\KernelPlugins({
     *      @Insomnia\Annotation\Endpoint( class="Controller\DocumentationController" ),
     *      @Insomnia\Annotation\Endpoint( class="Controller\PingController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\DocumentationController' );
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\PingController' );
    }
}