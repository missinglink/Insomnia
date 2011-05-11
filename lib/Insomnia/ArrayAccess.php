<?php

namespace Insomnia;

class ArrayAccess implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $data = array();

    public function merge( $data )
    {
        if( $data instanceof \Insomnia\ArrayAccess )
            $data = $data->toArray();
        
        $this->data = $data + $this->data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function replace( $data )
    {
        $this->data = $data;
    }

    public function clear()
    {
        $this->data = array();
    }

    public function expand( $key = null )
    {
        $this->data = array( $key => $this->data );
    }

    public function push( $value )
    {
        $this->data[] = $value;
    }

    public function getIterator()
    {
        return new \ArrayIterator( $this->data );
    }

    public function offsetSet( $offset, $value )
    {
        if ( !isset( $offset ) ) $this->data[] = $value;
        else $this->data[ $offset ] = $value;
    }

    public function offsetExists( $offset )
    {
        return isset( $this->data[ $offset ] );
    }

    public function offsetUnset( $offset )
    {
        unset( $this->data[ $offset ] );
    }

    public function offsetGet( $offset )
    {
        return isset( $this->data[ $offset ] ) ? $this->data[ $offset ] : null;
    }

    public function count()
    {
        return \count( $this->data );
    }

    public function get( $offset )
    {
        return isset( $this->data[ $offset ] ) ? $this->data[ $offset ] : null;
    }

    public function set( $offset, $value )
    {
        return $this->data[ $offset ] = $value;
    }

    public function prepend( $offset, $value )
    {
        $this->data = array( $offset => $value ) + $this->data;
    }
}