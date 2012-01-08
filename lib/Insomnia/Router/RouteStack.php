<?php

namespace Insomnia\Router;

use \Doctrine\Common\Cache;
use \Doctrine\Common\Cache\ArrayCache;
use \Insomnia\Pattern\ArrayAccess;

class RouteStack extends ArrayAccess
{
    const CACHEKEY = 'Insomnia_RouteStack';
    const CACHETTL = 5000;
    
    private $cache = null;
    
    public function __construct( Cache $cache = null )
    {
        $this->setCache( $cache instanceof Cache ? $cache : new ArrayCache );
        $this->load();
    }
    
    public function load()
    {
        if( $this->cache instanceof Cache )
        {
            $cacheHit = $this->cache->fetch( self::CACHEKEY );
            
            if( is_array( $cacheHit ) )
            {
                $this->merge( $cacheHit );
            }
        }
    }
    
    public function save()
    {
        if( $this->cache instanceof Cache )
        {
            $this->cache->save( self::CACHEKEY, $this->toArray(), self::CACHETTL );
        }
    }
    
    public function getCache()
    {
        return $this->cache;
    }

    public function setCache( Cache $cache )
    {
        $this->cache = $cache;
    }
}