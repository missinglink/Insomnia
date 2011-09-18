<?php

namespace Insomnia\Kernel\Module\Console;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
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