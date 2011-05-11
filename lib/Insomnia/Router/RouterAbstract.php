<?php

namespace Insomnia\Router;

use \Insomnia\Dispatcher,
    \Insomnia\Request;

class RouterAbstract
{
    protected $dispatcher,
              $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
        $this->setDispatcher( new Dispatcher );
    }

    public function setDispatcher( $dispatcher )
    {
        $this->dispatcher = $dispatcher;
    }

    public function match( $route )
    {
        if( $route->match( $this->request->getPath() ) )
            $this->dispatcher->dispatch( $this->request, $route );
    }

    public function run()
    {
        throw new RouterException( 'Failed to Match any Routes' );
    }
}

class RouterException extends \Exception {};