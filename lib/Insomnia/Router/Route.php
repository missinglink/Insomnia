<?php

namespace Insomnia\Router;

use \Insomnia\Registry;

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

    public function match()
    {    
        $this->params = array();
        $this->params[ 'version' ]    = 'v\d+';
        $this->params[ 'id' ]         = '\w+';
        
        $pattern = $this->createNamedPatterns();
        $pattern .= '(\.(?:json|xml|html|yaml|txt|ini|form))?';

        if( !\preg_match( "_^$pattern\$_", Registry::get( 'request' )->getParam( 'path' ), $matches ) )
            return false;

        if( !\in_array( Registry::get( 'request' )->getMethod(), $this->methods ) )
            return false;

        $this->matches = \array_intersect_key( $matches + $this->defaults, $this->defaults + $this->params );
        
        return true;
    }
    
    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern( $pattern )
    {
        if( \is_string( $pattern ) ) $this->pattern = $pattern;
    }

    private function createNamedPatterns()
    {
        $pattern = $this->pattern;
        
        if( false !== \strpos( $this->pattern, ':', 1 ) )
            foreach( $this->params as $key => $match )
                $pattern = \str_replace( ":$key", "(?P<$key>$match)", $pattern );
        
        return $pattern;
    }

    public function setDefault( $key, $value )
    {
        $this->defaults[ $key ] = $value;
        return $this;
    }

    public function setParams( $params )
    {
        if( \is_array( $params ) ) $this->params = $params;
        return $this;
    }
    
    public function getReflectionMethod()
    {
        return $this->reflectionMethod;
    }

    public function setReflectionMethod( $reflectionMethod )
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
        return $this->view;
    }

    public function setView( $view )
    {
        $this->view = $view;
    }
}