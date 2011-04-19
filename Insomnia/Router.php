<?php

namespace Insomnia;

class Router extends Data
{
    public function dispatch( Request $request, $controllerPath = \null )
    {
        $uri = $request->getUri();
        if( \is_null( $controllerPath ) ) $controllerPath = __DIR__ . \DIRECTORY_SEPARATOR . 'Controller' . \DIRECTORY_SEPARATOR;

        if( \is_dir( $controllerPath ) )
            foreach( $this->data as $route )
                if( $route->match( $uri ) )
                    if( isset( $route[ 'controller' ] ) )
                        if( $this->instantiate( $request, $route, $controllerPath ) )
                            return true;

        throw new RouterException( 'Failed to Match any Routes' );
    }

    private function instantiate( Request $request, RegexRoute $route, $controllerPath )
    {
        $camelCaseName = \ucfirst( $route[ 'controller' ] ) . 'Controller';
        if ( false === \realpath( $controllerPath . $camelCaseName . '.php' ) ) return \false;

        $class = '\Insomnia\Controller\\' . $camelCaseName;
        $request->data = \array_merge( $route->data, $request->data );

        $this->preDispatch( $request, $route );
        $c = new $class( $request, $route );
        $action = $route->getAction( $request->getMethod() );
        if( \method_exists( $c, $action ) ) $c->{ $action }( isset( $request['id'] ) ? $request['id'] : \false );
        $this->postDispatch( $request );
        
        return true;
    }

    public function preDispatch( Request $request, RegexRoute $route ){}
    public function postDispatch( Request $request ){}
}

class RouterException extends \Exception {};