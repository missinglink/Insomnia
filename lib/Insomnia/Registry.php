<?php

namespace Insomnia;

/**
 * A general purpose object store
 */
class Registry
{
    public static $store = array();

    /**
     * Store an object
     *
     * @param string $key Registry key
     * @param mixed $value Value
     */
    public static function set( $key, $value )
    {
        if( null === $value ) unset( self::$store[ $key ] );
        else self::$store[ $key ] = $value;
    }

    /**
     * Retrieve an object
     *
     * @param string $key Registry key
     * @return mixed Value
     */
    public static function get( $key )
    {
        if( isset( self::$store[ $key ] ) ) return self::$store[ $key ];
        else return null;
    }
}