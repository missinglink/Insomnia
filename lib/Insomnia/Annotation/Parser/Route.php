<?php

namespace Insomnia\Annotation\Parser;

use \Insomnia\Router\AnnotationReader;
use \Insomnia\Pattern\ArrayAccess;
use \Insomnia\Request;
use \Insomnia\Kernel\Module\RequestValidator\Request\ValidatorException;

class Route extends ArrayAccess
{
    public function __construct( AnnotationReader $reader, Request $request )
    {
        $classAnnotations = $reader->getClassAnnotations();
        if( !isset( $classAnnotations[ 'Insomnia\Annotation\Resource' ] ) ) return;
        
        foreach( $reader->getReflectionMethods() as $method )
        {
            $methodAnnotations = $reader->getMethodAnnotations( $method );
            if( !isset( $methodAnnotations[ 'Insomnia\Annotation\Route' ] ) ) continue;
            
            $this->addRoute( $classAnnotations, $methodAnnotations, $method, $request );
        }
    }
    
    private function addRoute( $classAnnotations, $methodAnnotations, $method, $request )
    {
        $route = new \Insomnia\Router\Route;
        $route->setRequest( $request );
        $route->setReflectionMethod( $method );
        $route->setClass( $method->getDeclaringClass()->getName() );

        $pattern = isset( $classAnnotations['Insomnia\Annotation\Route']['value'] )
            ? $classAnnotations['Insomnia\Annotation\Route']['value'] : '';

        if( isset( $methodAnnotations['Insomnia\Annotation\Route']['value'] ) )
            $route->setPattern( $pattern . $methodAnnotations['Insomnia\Annotation\Route']['value'] );

        if( isset( $methodAnnotations['Insomnia\Annotation\Route']['name'] ) )
            $route->setName( $methodAnnotations['Insomnia\Annotation\Route']['name'] );

        if( isset( $methodAnnotations[ 'Insomnia\Annotation\Method' ][ 'value' ] ) )
            $route->setMethods( \explode( ' ', \strtoupper( $methodAnnotations[ 'Insomnia\Annotation\Method' ][ 'value' ] ) ) );
        
        if( isset( $methodAnnotations[ 'Insomnia\Annotation\Request' ][ 'value' ] ) )
        {
            foreach( $methodAnnotations[ 'Insomnia\Annotation\Request' ][ 'value' ] as $param )
            {
                if( !isset( $param[ 'name' ] ) || empty( $param[ 'name' ] ) )
                {
                    throw new \Exception( 'Parameter name is required' );
                }
                
                if( !isset( $param[ 'optional' ] ) || $param[ 'optional' ] != 'true' )
                {
                    $name = trim( $param[ 'name' ] );
                    $type = isset( $param[ 'type' ] ) ? $param[ 'type' ] : 'string';
                    
                    switch( $type )
                    {
                        case 'alphanumeric' :
                            $route->setParam( $name, '[a-zA-Z0-9]+' );
                            break;
                        
                        case 'string' :
                            $route->setParam( $name, '.+' );
                            break;
                        
                        case 'integer' :
                            $route->setParam( $name, '\d+' );
                            break;
                        
                       case 'regex' :
                            if( !isset( $param[ 'regex' ] ) || empty( $param[ 'regex' ] ) )
                            {
                                throw new ValidatorException( 'You must provide a valid regex' );
                            }
                            
                            $route->setParam( $name, $param[ 'regex' ] );
                            break;
                    }                
                }
            }
        }

        $viewFile = isset( $classAnnotations['Insomnia\Annotation\View']['value'] )
            ? $classAnnotations['Insomnia\Annotation\View']['value'] : '';

        if( isset( $methodAnnotations[ 'Insomnia\Annotation\View' ][ 'value' ] ) )
            $route->setView( $viewFile . $methodAnnotations[ 'Insomnia\Annotation\View' ][ 'value' ] );
        
        // Convert route into regex for matching
        $route->createNamedPatterns();

        if( '' == $route->getName() ) $this[] = $route;
        else $this[ $route->getName() ] = $route;
    }
}
