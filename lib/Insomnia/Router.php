<?php

namespace Insomnia;

use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteDispatcher;
use \Insomnia\Router\RouterException,
    \Insomnia\Router\RouteStack,
    \Doctrine\Common\Cache\ApcCache;

class Router
{
    private $classes;
    
    public function dispatch( Request $request )
    {
        Registry::set( 'request', $request );
        
        /** @var $route \Insomnia\Router\Route */
        foreach( $this->loadRoutes( $request ) as $route )
        {
            // Attempt to dispatch the route
            if( $route->match( $request ) )
            {
                new RouteDispatcher( $route );
            }       
        }
        
        throw new RouterException( 'Failed to Match any Routes', 404 );
    }
    
    private function loadRoutes( Request $request )
    {
        $routes = new RouteStack;
        
        if( 0 === $routes->count() )
        {
            foreach( $this->classes as $controllerClass )
            {
                $reader = new AnnotationReader( $controllerClass );
                $routes->merge( new RouteParser( $reader, $request ) );
            }
            
            // Commit Cache
            $routes->save();
        }
        
        return $routes;
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