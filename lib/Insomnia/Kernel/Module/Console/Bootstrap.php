<?php

namespace Insomnia\Kernel\Module\Console;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia console module
 * 
 * Allows execution via the command line.
 * 
 * @insomnia:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * @insomnia:KernelPlugins({
     *      @insomnia:Endpoint( class="Controller\KernelController" ),
     *      @insomnia:RequestPlugin( class="Request\Plugin\ConsoleParamParser" ),
     *      @insomnia:ResponsePlugin( class="Response\Plugin\ConsoleOutput" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function bootstrap( Kernel $kernel )
    {
        if( php_sapi_name() == 'cli' && empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            $kernel->addEndpoint( __NAMESPACE__ . '\Controller\KernelController' );
            $kernel->addRequestPlugin( new Request\Plugin\ConsoleParamParser );
            $kernel->addResponsePlugin( new Response\Plugin\ConsoleOutput, 1 );
        }
    }
}