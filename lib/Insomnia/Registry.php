<?php

namespace Insomnia;

class Registry
{
    public static $store = array();
    
    public static function set( $key, $value )
    {
        if( null === $value ) unset( self::$store[ $key ] );
        else self::$store[ $key ] = $value;
    }

    public static function get( $key )
    {
        if( isset( self::$store[ $key ] ) ) return self::$store[ $key ];
        else return null;
    }
}