<?php

namespace Community\Module\Console;

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
     */
    public function run()
    {
        if( php_sapi_name() == 'cli' && empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            Kernel::addEndpoint( __NAMESPACE__ . '\Controller\KernelController' );
            Kernel::addRequestPlugin( new Request\Plugin\ConsoleParamParser );
            Kernel::addResponsePlugin( new Response\Plugin\ConsoleOutput, 1 );
        }
    }
}