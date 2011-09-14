<?php

namespace Insomnia\Kernel\Module\Compatability;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addRequestPlugin( new Request\Plugin\MethodOverride );
        
        $kernel->addResponsePlugin( new Response\Plugin\VersionHeaders );
    }
}