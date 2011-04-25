<?php

namespace Insomnia\Router;

use \Insomnia\ArrayAccess,
    \Insomnia\Dispatcher,
    \Insomnia\Request;

class RouterAbstract extends ArrayAccess
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

    public function offsetSet( $offset, $route )
    {
        if( $route->match( $this->request->getPath() ) )
            $this->dispatcher->dispatch( $this->request, $route );

        parent::offsetSet( $offset, $route );
    }

    public function run()
    {
        throw new RouterException( 'Failed to Match any Routes' );
    }
}

class RouterException extends \Exception {};