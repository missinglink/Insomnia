<?php

namespace Insomnia;

class Router extends Data
{
    public function dispatch( Request $request )
    {
        $uri = $request->getUri();
        
        if( \is_dir( Application::$config['path']['controller'] ) )
            foreach( $this->data as $route )
                if( $route->match( $uri ) )
                    if( isset( $route[ 'controller' ] ) )
                        if( $this->instantiate( $request, $route ) )
                            return true;

        throw new RouterException( 'Failed to Match any Routes' );
    }

    private function instantiate( Request $request, RegexRoute $route )
    {
        $camelCaseName = \ucfirst( $route[ 'controller' ] ) . 'Controller';
        if ( false === \realpath( Application::$config['path']['controller'] . $camelCaseName . '.php' ) ) return \false;

        $class = '\Insomnia\Controller\\' . $camelCaseName;
        $request->data = \array_merge( $route->data, $request->data );

        $this->preDispatch( $request, $route );
        $c = new $class( $request, $route );
        $c->startUp();
        $action = $route->getAction( $request->getMethod() );
        if( \method_exists( $c, $action ) ) $c->{ $action }( isset( $request['id'] ) ? $request['id'] : \false );
        $c->shutDown();
        $this->postDispatch( $request );
        
        return true;
    }

    public function preDispatch( Request $request, RegexRoute $route ){}
    public function postDispatch( Request $request ){}
}

class RouterException extends \Exception {};