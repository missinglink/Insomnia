<?php

namespace Insomnia\Kernel\Module\Session\Storage;

use \Insomnia\Kernel\Module\Session\StorageAbstract,
    \Memcache as Driver;

class Memcache extends StorageAbstract
{
    public function __construct()
    {
        $this->driver = new Driver;
    }
    public function open( $savePath, $sessionName )
    {
        return $this->driver->connect( 'localhost', '11211' );
    }

    public function close()
    {
        return $this->driver->close();
    }

    public function read( $key )
    {
        return $this->driver->get( $this->prefix . $key );
    }

    public function write( $key, $value )
    {
        return $this->driver->set( $this->prefix . $key, $value, null, $this->timeout );
    }

    public function destroy( $key )
    {
        return $this->driver->delete( $this->prefix . $key, 0 );
    }
}