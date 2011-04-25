<?php

namespace Insomnia\Router;

use \Insomnia\ArrayAccess;

class Route extends ArrayAccess
{
    private $pattern = '',
            $params = array(),
            $actions = array(),
            $defaults = array();
    
    public function __construct( $pattern )
    {
        if( \is_string( $pattern ) ) $this->pattern = $pattern;
    }

    public function match( $uri )
    {
        $this->createNamedPatterns();
        if( !\preg_match( "_^$this->pattern\$_", $uri, $matches ) ) return false;

        $matches = array_merge( $this->defaults, $matches );
        $params  = array_merge( $this->params, $this->defaults );
        
        $this->data = \array_merge( array_intersect_key( $matches, $params ), $this->data );
        return true;
    }

    private function createNamedPatterns()
    {
        if( is_numeric( \strpos( $this->pattern, ':' ) ) )
            foreach( $this->params as $key => $match )
                $this->pattern = str_replace( ":$key", "(?P<$key>$match)", $this->pattern );
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
        return isset( $this->actions[ $method ] )
            ? $this->actions[ $method ]
            : false;
    }
}