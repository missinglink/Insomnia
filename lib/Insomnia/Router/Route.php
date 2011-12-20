<?php

// @TODO; this method has too many private properties.

namespace Insomnia\Router;

use \Insomnia\Registry;
use \Insomnia\Request;

class Route
{
    private $matches = array(),
            $pattern = '',
            $params = array(),
            $methods = array(),
            $name = '',
            $reflectionMethod = array(),
            $defaults = array(),
            $view = '';
    
    private $request;

    public function match( Request $request )
    {
        $this->setRequest( $request );
        $pattern = $this->createNamedPatterns();
        $pathWithoutFileExtension = str_replace( $request->getFileExtension(), '', $request->getParam( 'path' ) );
        
        if( !preg_match( "_^$pattern\$_", $pathWithoutFileExtension, $matches ) )
            return false;
        
        $method = $request->getMethod();

        if( !\in_array( $method, $this->methods ) )
            return false;

        $this->matches = array_intersect_key( $matches + $this->defaults, $this->defaults + $this->params );
        
        return true;
    }
    
    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern( $pattern )
    {
        if( is_string( $pattern ) ) $this->pattern = $pattern;
    }

    private function createNamedPatterns()
    {
        $pattern = $this->pattern;
        
        if( false !== strpos( $this->pattern, ':', 1 ) )
        {
            // Sort params by longest string length first
            // This prevents a param named 'a' from matching before one called 'ab'
            uasort( $this->params, function( $a, $b ) {
                return strlen( $b ) - strlen( $a );
            });

            foreach( $this->params as $key => $match )
            {
                $maxReplace = 1; // For some reason PHP wants this passed by reference
                $pattern = str_replace( ":$key", "(?P<$key>$match)", $pattern, $maxReplace );
            }
        }
        
        return $pattern;
    }

    public function setDefault( $key, $value )
    {
        $this->defaults[ $key ] = $value;
        return $this;
    }

    public function setParams( $params )
    {
        if( is_array( $params ) ) $this->params = $params;
        return $this;
    }
    
    public function setParam( $key, $regex )
    {
        $this->params[ $key ] = $regex;
        return $this;
    }
    
    /**
     * @return \ReflectionMethod
     */
    public function getReflectionMethod()
    {
        return $this->reflectionMethod;
    }

    public function setReflectionMethod( \ReflectionMethod $reflectionMethod )
    {
        $this->reflectionMethod = $reflectionMethod;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }
        
    public function setMethods( $methods = array() )
    {
        $this->methods = $methods;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getMatches()
    {
        return $this->matches;
    }
    
    public function getView()
    {
//        var_dump( 'deprecated' );
        return $this->view;
    }

    public function setView( $view )
    {
//        var_dump( 'deprecated' );
        $this->view = $view;
    }
    
    /** @return \Insomnia\Request */
    public function getRequest()
    {
        return $this->request;
}

    public function setRequest( Request $request )
    {
        $this->request = $request;
    }
}