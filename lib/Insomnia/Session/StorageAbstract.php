<?php

namespace Insomnia\Session;

abstract class StorageAbstract
{
    protected $timeout = 300, // 5 mins
              $prefix = 'session_';

    public function setTimeout( $timeout )
    {
        $this->timeout = $timeout;
    }

    public function setPrefix( $timeout )
    {
        $this->timeout = $timeout;
    }

    abstract public function read( $key );
    abstract public function write( $key, $value );
    abstract public function destroy( $key );

    public function open( $savePath, $sessionName )
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function gc()
    {
        return true;
    }
}