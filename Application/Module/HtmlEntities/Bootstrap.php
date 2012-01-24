<?php

namespace Application\Module\HtmlEntities;

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
     *      @insomnia:Endpoint( class="Controller\WelcomeController" )
     * })
     */
    public function run()
    {
        Kernel::addEndpoint( __NAMESPACE__ . '\Controller\HtmlEntitiesController' );
    }
}