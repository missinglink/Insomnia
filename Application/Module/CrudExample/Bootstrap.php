<?php

namespace Application\Module\CrudExample;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia default welcome screen
 * 
 * Provides a front page for the application.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:Endpoint( class="Controller\CrudController" )
     * })
     */
    public function run()
    {
        Kernel::addEndpoint( __NAMESPACE__ . '\Controller\CrudController' );
    }
}