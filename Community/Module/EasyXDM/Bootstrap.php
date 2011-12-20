<?php

namespace Community\Module\EasyXDM;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia EasyXDM Module
 * 
 * Cross-Domain Messaging made easy
 * 
 * @link http://easyxdm.net/
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
     *      @insomnia:Endpoint( class="Controller\EasyXDMController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\EasyXDMController' );
    }
}