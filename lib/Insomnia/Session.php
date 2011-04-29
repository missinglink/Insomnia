<?php

namespace Insomnia;

use \Insomnia\Session\SessionAbstract,
    \Insomnia\Session\AuthenticationAbstract,
    \Insomnia\Session\StorageAbstract,
    \Insomnia\Session\Storage\Apc as SessionStorage,
    \Insomnia\Session\Authentication\Token as SessionAuthentication;

class SessionException extends \Exception {}

class Session extends SessionAbstract
{
    protected static $authentication,
                     $storage;

    public function  __construct()
    {
        self::setName( 'SESSION' );
        self::setStorage( new SessionStorage );
        self::setAuthentication( new SessionAuthentication );
        self::start();
    }

    public static function authenticate( $request )
    {
        self::$authentication->authenticate( $request );
        
        if( \is_null( \Insomnia\Session::get( 'id' ) ) )
            throw new SessionException( 'Authentication Failed' );
    }

    public static function setAuthentication( AuthenticationAbstract $authentication )
    {
        self::$authentication = $authentication;
    }

    public static function setStorage( StorageAbstract $storage )
    {
        if( $storage instanceof \Insomnia\Session\Storage\Disk )
            return;

        self::$storage = $storage;

        \ini_set( 'session.gc_probability', 0 );
        \session_set_save_handler
        (
            array( self::$storage, 'open' ),
            array( self::$storage, 'close' ),
            array( self::$storage, 'read' ),
            array( self::$storage, 'write' ),
            array( self::$storage, 'destroy' ),
            array( self::$storage, 'gc' )
        );
    }

    public static function getStorage()
    {
        return self::$storage;
    }

    public static function getId()
    {
        return \session_id();
    }

    public static function setId( $id )
    {
        return \session_id( $id );
    }

    public static function getName()
    {
        return \session_name();
    }

    public static function setName( $name )
    {
        \session_name( $name );
    }

    public static function start()
    {
        \session_start();
    }

    public static function close()
    {
        \session_write_close();
    }

    public static function clear()
    {
        \session_unset();
        self::useId();
    }

    public static function destroy()
    {
        \session_destroy();
    }

    public static function useId( $id = null )
    {
        if( isset( $id ) )
        {
            $name = self::getName();
            self::close();
            self::setId( $id );
            self::setName( $name );
            self::start();
        }
        
        \Insomnia\Session::set( 'id', \Insomnia\Session::getId() );
    }
}