<?php

namespace Insomnia\Kernel\Module\RequestValidator;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addDispatcherPlugin( new Dispatcher\Plugin\ParamAnnotationValidator );
    }
}