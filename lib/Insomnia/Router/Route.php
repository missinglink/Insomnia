<?php

namespace Insomnia\Router;

use \Insomnia\Registry;

class Route
{
    private $matches = array(),
            $pattern = '',
            $params = array(),
            $actions = array(),
            $defaults = array();
    
    public function __construct( $pattern )
    {
        if( \is_string( $pattern ) ) $this->pattern = $pattern . '(\.(?:json|xml|html|yaml|txt|ini))?';
    }

    public function match()
    {
        $this->createNamedPatterns();
        
        if( !\preg_match( "_^$this->pattern\$_", Registry::get( 'request' )->getPath(), $matches ) )
            return false;

        $this->matches = \array_intersect_key( $matches + $this->defaults, $this->defaults + $this->params );
        
        Registry::get( 'dispatcher' )->dispatch( $this );
    }

    private function createNamedPatterns()
    {
        if( false !== \strpos( $this->pattern, ':', 1 ) )
            foreach( $this->params as $key => $match )
                $this->pattern = \str_replace( ":$key", "(?P<$key>$match)", $this->pattern );
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

    public function setAction( $method, $action )
    {
        $this->actions[ $method ] = $action;
        return $this;
    }

    public function getAction( $method )
    {
        if( isset( $this->actions[ $method ] ) )
            return $this->actions[ $method ];

        if( isset( $this->actions[ 'ANY' ] ) )
            return $this->actions[ 'ANY' ];

        return false;
    }

    public function getMatches()
    {
        return $this->matches;
    }
}