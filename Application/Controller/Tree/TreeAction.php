<?php

namespace Application\Controller\Tree;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

class TreeAction extends Action
{
    public function action()
    {
        echo '<pre>';

        $json = '{"moo":{"woof":{"meow":{"dwqd":{"qwd":{"qw":{"d":"cow"}}},"dwqa":{"qwd":{"qw":{"a":"cow"}}}}}}}';
        
        $request = Registry::get( 'request' );

        $tree = new Tree( \json_decode( $json, true ) );

        //$tree[ 'moo' ] = 'cow';
        //$tree[ 'moo/moo' ] = 'cow';
        //$tree[ 'moo/woof/meow' ] = 'cow';

        $tree[ 'moo/woof/meow/dwqd/qwd/qw/d' ] = 'coww';
        $tree[ 'moo/woof/meow/dwqa/qwd/qw/a' ] = 'cow';

        //unset( $tree[ 'moo/woof/meow' ] );

        var_dump( array_keys( $tree[ 'moo/woof/meow' ] ) );
        //print_r( $tree[ 'moo/woof/meow' ]->keys() );

        //echo json_encode( $tree->toArray() ) . PHP_EOL;

        
//        var_dump( $tree[ 'moo' ] );
//        var_dump( $tree[ 'moo/moo' ] );
//        var_dump( $tree[ 'moo' ][ 'moo' ] );
//        var_dump( $tree[ 'moo/moo/moo' ] );
        //var_dump( isset( $tree[ 'moo' ] ) );


        //print_r( $tree[ 'moo' ]->toArray() );
//        var_dump( isset( $tree[ 'mooo/woof/meow' ] ) );
//        var_dump( $tree[ 'mooo/woof/meow' ] );
//        var_dump( isset( $tree[ 'moo/woof/meow' ] ) );
//        print_r( $tree[ 'moo/woof/meow' ] );

//        echo PHP_EOL;
        //unset( $tree[ 'moo/woof' ] );
//        var_dump( isset( $tree[ 'moo/woof/meow' ] ) );
//        var_dump( $tree[ 'moo/woof/meow' ] );
        //var_dump( $tree[ 'moo' ][ 'woof' ][ 'meow' ] );
        echo $tree;
        die;
    }
}

class Tree implements \ArrayAccess
{
    private $storage;

    public function __construct( $data = array() )
    {
        $this->storage = new ArrayStorage( $data );
    }

    public function offsetExists( $offset )
    {
        return ( null !== $this->storage->read( $offset ) );
    }
    
    public function offsetGet( $offset )
    {
        return $this->storage->read( $offset );
    }
    
    public function offsetSet( $offset, $value )
    {
        $this->storage->write( $offset, $value );
    }

    public function offsetUnset( $offset )
    {
        $this->storage->destroy( $offset );
    }

    public function toArray()
    {
        return $this->storage->toArray();
    }

    public function __toString()
    {
        return \print_r( $this->storage->toArray(), true );
    }
}

class ArrayStorage extends \ArrayObject
{
    const DELIMITER = '/';
    const CREATE = 'array'; // object || array

    public function read( $key, &$object = null )
    {
        if( null === $object ) $object = $this;

        if(( $k = \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER, true ) ))
            if( isset( $object[ $k ] ) && ( \is_array( $object[ $k ] ) || $object[ $k ] instanceof static ) )
                return $this->read( \substr( \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER ), 1), $object[ $k ] );

        return isset( $object[ $key ] ) ? $object[ $key ] : null;
    }

    public function write( $key, $value, &$object = null )
    {
        if( null === $object ) $object = $this;

         if(( $k = \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER, true ) ))
         {
            if( !isset( $object[ $k ] ) || !( \is_array( $object[ $k ] ) || $object[ $k ] instanceof static ) )
                $object[ $k  ] = ( self::CREATE === 'object' ) ? new static : array();

            $this->write( \substr( \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER ), 1), $value, $object[ $k ] );
        }

        else $object[ $key ] = $value;
    }

    public function destroy( $key, &$object = null )
    {
        if( null === $object ) $object = $this;

        if(( $k = \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER, true ) ))
        {
            if( isset( $object[ $k ] ) && ( \is_array( $object[ $k ] ) || $object[ $k ] instanceof static ) )
                $this->destroy( \substr( \strstr( \trim( $key, self::DELIMITER ), self::DELIMITER ), 1), $object[ $k ] );
        }

        else unset( $object[ $key ] );
    }

    public function toArray( $recursive = true )
    {
        $result = array();
        foreach( $this as $k => $v )
            $result[ $k ] = ( $recursive && $v instanceof static )
                ? $v->toArray() : $v;

        return $result;
    }

    public function keys()
    {
        return \array_keys( $this->toArray( false ) );
    }
}