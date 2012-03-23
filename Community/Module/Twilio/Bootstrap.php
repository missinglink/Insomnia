<?php

namespace Community\Module\Twilio;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/** 
 * @Insomnia\Annotation\Module
 * @beta
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @Insomnia\Annotation\KernelPlugins({
     *      @Insomnia\Annotation\Endpoint( class="Controller\TwilioController" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\TwilioController' );
    }
}