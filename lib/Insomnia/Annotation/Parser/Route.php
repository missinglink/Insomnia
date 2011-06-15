<?php

namespace Insomnia\Annotation\Parser;

use Insomnia\Router\RouteStack;
use Insomnia\Router\AnnotationReader;

class Route extends \Insomnia\ArrayAccess
{    
    public function __construct( AnnotationReader $reader )
    {
        $classAnnotations = $reader->getClassAnnotations();
        if( !isset( $classAnnotations[ 'Insomnia\Annotation\Resource' ] ) ) return;
        
        foreach( $reader->getReflectionMethods() as $method )
        {
            $methodAnnotations = $reader->getMethodAnnotations( $method );
            if( !isset( $methodAnnotations[ 'Insomnia\Annotation\Route' ] ) ) continue;
            
            $this->addRoute( $classAnnotations, $methodAnnotations, $method );
        }
    }
    
    private function addRoute( $classAnnotations, $methodAnnotations, $method )
    {
        $route = new \Insomnia\Router\Route;
        $route->setReflectionMethod( $method );

        $pattern = isset( $classAnnotations['Insomnia\Annotation\Route']['value'] )
            ? $classAnnotations['Insomnia\Annotation\Route']['value'] : '';

        if( isset( $methodAnnotations['Insomnia\Annotation\Route']['value'] ) )
            $route->setPattern( $pattern . $methodAnnotations['Insomnia\Annotation\Route']['value'] );

        if( isset( $methodAnnotations['Insomnia\Annotation\Route']['name'] ) )
            $route->setName( $methodAnnotations['Insomnia\Annotation\Route']['name'] );

        if( isset( $methodAnnotations[ 'Insomnia\Annotation\Method' ][ 'value' ] ) )
            $route->setMethods( \explode( ' ', \strtoupper( $methodAnnotations[ 'Insomnia\Annotation\Method' ][ 'value' ] ) ) );

        $viewFile = isset( $classAnnotations['Insomnia\Annotation\View']['value'] )
            ? $classAnnotations['Insomnia\Annotation\View']['value'] : '';

        if( isset( $methodAnnotations[ 'Insomnia\Annotation\View' ][ 'value' ] ) )
            $route->setView( $viewFile . $methodAnnotations[ 'Insomnia\Annotation\View' ][ 'value' ] );

        if( '' == $route->getName() ) $this[] = $route;
        else $this[ $route->getName() ] = $route;
    }
}
