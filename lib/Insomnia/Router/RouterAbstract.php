<?php

namespace Insomnia\Router;

use \Insomnia\Registry;

class RouterAbstract
{
    public function match( $route )
    {
        if( $route->match( Registry::get( 'request' )->getPath() ) )
            Registry::get( 'dispatcher' )->dispatch( $route );
    }
}