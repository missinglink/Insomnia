<?php

namespace Insomnia\Component\Documentation;

use \Insomnia\Kernel,
    \Insomnia\Pattern\Component;

class DocumentationComponent extends Component
{
    public function bootstrap( Kernel $kernel )
    {
        $kernel->addDispatcherPlugin( new Dispatcher\Plugin\DocumentationEndPoint );
        
        $kernel->addEndPoint( new Controller\DocumentationController );
    }
}