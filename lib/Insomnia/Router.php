<?php

namespace Insomnia;

use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Router\RouteDispatcher;

class Router
{
    private $classes;
    
    public function dispatch()
    {
        $request = new Request;
        Registry::set( 'request', $request );

        $routes = new RouteStack;
        
        foreach( $this->classes as $controllerClass )
        {
            $reader = new AnnotationReader( $controllerClass );
            $routes->merge( new RouteParser( $reader, $request ) );
        }
        
        /** @var $route \Insomnia\Router\Route */
        foreach( $routes as $route )
        {
            if( $route->match( $request ) )
            {
                // Attempt to dispatch the route
                new RouteDispatcher( $route );
            }       
        }
        
        throw new \Insomnia\Router\RouterException( 'Failed to Match any Routes' );
    }
    
    public function addClass( $class )
    {
        $this->classes[] = $class;
    }
    
    public function getClasses()
    {
        return $this->classes;
    }

    public function setClasses( $classes )
    {
        $this->classes = $classes;
    }
}