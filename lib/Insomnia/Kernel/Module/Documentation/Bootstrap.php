<?php

namespace Insomnia\Kernel\Module\Documentation;

use \Insomnia\Kernel,
    \Insomnia\Pattern\KernelModule;

class Bootstrap extends KernelModule
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addDispatcherPlugin( new Dispatcher\Plugin\DocumentationEndPoint );
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\DocumentationController' );
        $kernel->addEndPoint( __NAMESPACE__ . '\Controller\PingController' );
    }
}