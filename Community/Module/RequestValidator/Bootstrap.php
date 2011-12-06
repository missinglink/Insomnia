<?php

namespace Community\Module\RequestValidator;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia request validator module
 * 
 * Provides a basic request validator.
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
     *      @insomnia:AnnotationParser( class="Dispatcher\Plugin\ParamAnnotationValidator" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addDispatcherPlugin( new Dispatcher\Plugin\ParamAnnotationValidator );
    }
}