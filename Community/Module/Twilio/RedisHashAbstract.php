<?php

namespace Community\Module\Twilio;

require_once( \ROOT . 'lib/rediska/library/Rediska/Key.php' );

class RedisHashAbstract
{
    const KEY = 'data';
    private $_id;
    
    public function __construct( $id = null )
    {
        $this->_id = $id;
    }
    
    public function delete()
    {
        $key = new \Rediska_Key( static::KEY . ':' . $this->getId() );
        return $key->delete();
    }
    
    public function __set( $name, $value )
    {
        $key = new \Rediska_Key_Hash( static::KEY . ':' . $this->getId() );
        $key->set( $name, $value );
    }
    
    public function __get( $name )
    {        
        $key = new \Rediska_Key_Hash( static::KEY . ':' . $this->getId() );
        return $key->get( $name );
    }
    
    public function __isset( $name )
    {
        $key = new \Rediska_Key_Hash( static::KEY . ':' . $this->getId() );
        return $key->exists( $name );
    }
    
    public function __unset( $name )
    {
        $key = new \Rediska_Key_Hash( static::KEY . ':' . $this->getId() );
        $key->delete( $name );
    }
    
    private function generateId()
    {
        $key = new \Rediska_Key( static::KEY . '_increment' );
        return $key->increment();
    }
    
    public function getId( $strict = true )
    {
        // Autoincrement if key is not set
        if( null === $this->_id )
        {
            $this->_id = $this->generateId();
        }
        
        return $this->_id;
    }

    public function setId( $id )
    {
        $this->_id = $id;
    }
}
