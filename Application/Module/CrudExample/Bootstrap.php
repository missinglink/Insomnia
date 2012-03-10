<?php

namespace Application\Module\CrudExample;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia default welcome screen
 * 
 * Provides a front page for the application.
 * 
 * Insomnia\Annotation\:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * Insomnia\Annotation\:KernelPlugins({
     *      Insomnia\Annotation\:Endpoint( class="Controller\CrudController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addEndpoint( __NAMESPACE__ . '\Controller\CrudController' );
    }
}