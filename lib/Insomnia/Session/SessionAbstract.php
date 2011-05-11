<?php

namespace Insomnia\Session;

class SessionAbstract implements \ArrayAccess, \IteratorAggregate, \Countable
{
    public function merge( $data )
    {
        $_SESSION = $data + $_SESSION;
    }

    public function toArray()
    {
        return $_SESSION;
    }
    
    public function getIterator()
    {
        return new \ArrayIterator( $_SESSION );
    }

    public function offsetSet( $offset, $value )
    {
        $_SESSION[ $offset ] = $value;
    }

    public function offsetExists( $offset )
    {
        return isset( $_SESSION[ $offset ] );
    }

    public function offsetUnset( $offset )
    {
        unset( $_SESSION[ $offset ] );
    }

    public function offsetGet( $offset )
    {
        return isset( $_SESSION[ $offset ] ) ? $_SESSION[ $offset ] : null;
    }

    public function count()
    {
        return \count( $_SESSION );
    }

    public static function get( $offset )
    {
        return isset( $_SESSION[ $offset ] ) ? $_SESSION[ $offset ] : null;
    }

    public static function set( $offset, $value )
    {
        return $_SESSION[ $offset ] = $value;
    }
}