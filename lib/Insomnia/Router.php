<?php

namespace Insomnia;

use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Router\RouteDispatcher;
use \Insomnia\Router\RouterException;

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
            // Attempt to dispatch the route
            if( $route->match( $request ) )
            {
                new RouteDispatcher( $route );
            }       
        }
        
        throw new RouterException( 'Failed to Match any Routes', 404 );
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