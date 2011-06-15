<?php

namespace Insomnia;

use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;

class Router
{
    private $classes;
    
    public function dispatch( $name = null )
    {
        $routes = new RouteStack;
        
        foreach( $this->classes as $controllerClass )
        {
            $reader = new AnnotationReader( $controllerClass );
            $routes->merge( new RouteParser( $reader ) );
        }
        
        foreach( $routes as $route ) $route->match( $name );
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