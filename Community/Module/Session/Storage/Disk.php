<?php

namespace Community\Module\Session\Storage;

use \Community\Module\Session\StorageAbstract;

class Disk extends StorageAbstract
{
    public function __construct()
    {
//        \session_module_name( 'files' );
//        \session_cache_expire( $this->timeout / 60 );
    }

    public function read( $key )
    {
        return true;
    }

    public function write( $key, $value )
    {
        return true;
    }

    public function destroy( $key )
    {
        return true;
    }
}