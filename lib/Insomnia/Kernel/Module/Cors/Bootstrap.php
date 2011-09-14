<?php

namespace Insomnia\Kernel\Module\Cors;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addResponsePlugin( new Response\Plugin\CorsHeaders );
    }
}