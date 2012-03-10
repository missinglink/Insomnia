<?php

namespace Community\Module\Console;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

/**
 * Insomnia console module
 * 
 * Allows execution via the command line.
 * 
 * Insomnia\Annotation\:Module
 */
class Bootstrap extends KernelModule
{
    /**
     * Module configuration
     * 
     * Insomnia\Annotation\:KernelPlugins({
     *      Insomnia\Annotation\:Endpoint( class="Controller\KernelController" ),
     *      Insomnia\Annotation\:RequestPlugin( class="Request\Plugin\ConsoleParamParser" ),
     *      Insomnia\Annotation\:ResponsePlugin( class="Response\Plugin\ConsoleOutput" )
     * })
     * 
     * @param Kernel $kernel
     */
    public function run( Kernel $kernel )
    {
        if( php_sapi_name() == 'cli' && empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            $kernel->addEndpoint( __NAMESPACE__ . '\Controller\KernelController' );
            $kernel->addRequestPlugin( new Request\Plugin\ConsoleParamParser );
            $kernel->addResponsePlugin( new Response\Plugin\ConsoleOutput, 1 );
        }
    }
}