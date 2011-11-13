<?php

namespace Community\Module\Session\Storage;

use \Community\Module\Session\StorageAbstract;

class Apc extends StorageAbstract
{
    public function __construct()
    {
        \ini_set( 'session.gc_probability', 0 );
    }

    public function read( $key )
    {
        return \apc_fetch( $this->prefix . $key );
    }

    public function write( $key, $value )
    {
        return \apc_store( $this->prefix . $key, $value, $this->timeout );
    }

    public function destroy( $key )
    {
        return \apc_delete( $this->prefix . $key );
    }
}