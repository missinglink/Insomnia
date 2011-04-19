<?php

namespace Insomnia;

class Data implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $data = array();

    final public function getIterator()
    {
        return new \ArrayIterator( $this->data );
    }

    final public function offsetSet( $offset, $value )
    {
        if ( !isset( $offset ) ) $this->data[] = $value;
        else $this->data[ $offset ] = $value;
    }

    final public function offsetExists( $offset )
    {
        return isset( $this->data[ $offset ] );
    }

    final public function offsetUnset( $offset )
    {
        unset( $this->data[ $offset ] );
    }

    final public function offsetGet( $offset )
    {
        return isset( $this->data[ $offset ] ) ? $this->data[ $offset ] : null;
    }

    final public function count()
    {
        return count( $this->data );
    }
}