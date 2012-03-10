<?php

namespace Community\Module\Session;

use Community\Module\Session\Storage\Disk as SessionStorageMethod,
    Community\Module\Session\Authentication\Token as SessionAuthentication;

class Session extends SessionAbstract
{
    protected static $authentication,
                     $storage;

    public function  __construct( $sessionId = null )
    {
        self::setName( 'SESSION' );
        self::setStorage( new SessionStorageMethod );
        self::setAuthentication( new SessionAuthentication );
        
        if( null !== $sessionId )
        {
            self::useId( $sessionId );
        }
        
        else
        {
            self::useId( self::generateId() );
        }
    }

    public static function generateId()
    {
        return md5( time() . mt_rand( 0, \PHP_INT_MAX ) );
    }
    
    public static function authenticate( $request )
    {
        self::$authentication->authenticate( $request );
        
        if( null === self::get( 'id' ) )
        {
            throw new SessionException( 'Authentication Failed' );
        }
    }

    public static function setAuthentication( AuthenticationAbstract $authentication )
    {
        self::$authentication = $authentication;
    }

    public static function setStorage( StorageAbstract $storage )
    {
        if( $storage instanceof \Community\Module\Session\Storage\Disk )
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
        if( !self::validateId( $id ) )
        {
            throw new \Exception( "The session id is too long or contains illegal characters, valid characters are a-z, A-Z, 0-9 and '-'", 400 );
        }
        
        if( isset( $id ) )
        {
            $name = self::getName();
            self::close();
            self::setId( $id );
            self::setName( $name );
            self::start( self::generateId() );
        }
        
        self::set( 'id', self::getId() );
    }
    
    public static function validateId( $id = null )
    {
        // PHP is picky about the session id
        return preg_match( '/^[a-zA-Z0-9\-]{0,32}$/', $id );
    }
}