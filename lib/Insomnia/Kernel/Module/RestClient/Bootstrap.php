<?php

namespace Insomnia\Kernel\Module\RestClient;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\ClientController' );
    }
}