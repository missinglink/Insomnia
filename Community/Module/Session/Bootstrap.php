<?php

namespace Community\Module\Session;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia session module
 * 
 * Provides flexible stateful session handling.
 * 
 * @Insomnia\Annotation\Module
 * @beta
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        // This module is still under development
    }
}