<?php

namespace Insomnia;

class RegexRoute extends Data
{
    private $pattern = '';
    private $identifiers = array();
    private $actions = array();
    
    public function __construct( $pattern, $identifiers = array() )
    {
        $this->pattern = $pattern;
        \is_array( $identifiers ) && $this->identifiers = $identifiers;
    }

    public function match( $uri )
    {
        \preg_match( $this->pattern, $uri, $matches );
        if( \count( $this->identifiers ) != \count( $matches ) -1 ) return false;
        
        \array_shift( $matches );
        $matches = \array_combine( $this->identifiers, $matches );
        if( !array_key_exists( 'controller', $matches ) ) return false;

        $this->data = \array_merge( $matches, $this->data );
        return true;
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

        return false;
    }

    public function appendTo( $router )
    {
        $router[] = $this;
    }
}